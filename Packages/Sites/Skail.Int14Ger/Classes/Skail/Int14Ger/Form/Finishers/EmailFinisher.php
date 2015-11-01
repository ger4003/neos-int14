<?php
namespace Skail\Int14Ger\Form\Finishers;

use TYPO3\Eel\FlowQuery\FlowQuery;
use TYPO3\Flow\Property\Exception\InvalidPropertyException;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;

/**
 * This finisher sends an email to one recipient
 *
 * Options:
 *
 * - templatePathAndFilename (mandatory): Template path and filename for the mail body
 * - layoutRootPath: root path for the layouts
 * - partialRootPath: root path for the partials
 * - variables: associative array of variables which are available inside the Fluid template
 *
 * The following options control the mail sending. In all of them, placeholders in the form
 * of {...} are replaced with the corresponding form value; i.e. {email} as recipientAddress
 * makes the recipient address configurable.
 *
 * - subject (mandatory): Subject of the email
 * - recipientAddress: Email address of the recipient. If recipientAddress is not we try to get the email address from node definded by recipientNodeIdentifier
 * - recipientNodeIdentifier: Identifier of node having an email property or an property defined by recipientNodeAddressProperty
 * - recipientNodeAddressProperty: Name of node property containing email address
 * - recipientName: Human-readable name of the recipient
 * - senderAddress (mandatory): Email address of the sender
 * - senderName: Human-readable name of the sender
 * - replyToAddress: Email address of to be used as reply-to email
 * - format: format of the email (one of the FORMAT_* constants). By default mails are sent as HTML
 * - testMode: if TRUE the email is not actually sent but outputted for debugging purposes. Defaults to FALSE
 */
class EmailFinisher extends \TYPO3\Form\Finishers\EmailFinisher {

	/**
	 * Executes this finisher
	 * @see AbstractFinisher::execute()
	 *
	 * @return void
	 * @throws \TYPO3\Form\Exception\FinisherException
	 */
	protected function executeInternal() {
		$subject = $this->parseOption('subject');
		$recipientAddress = $this->getRecipientAddress();
		$recipientName = $this->getRecipientName();
		$senderAddress = $this->parseOption('senderAddress');
		$senderName = $this->parseOption('senderName');
		$replyToAddress = $this->parseOption('replyToAddress');
		$format = $this->parseOption('format');
		$testMode = $this->parseOption('testMode');

		if ($subject === NULL) {
			throw new \TYPO3\Form\Exception\FinisherException('The option "subject" must be set for the EmailFinisher.', 1327060320);
		}
		if ($recipientAddress === NULL) {
			throw new \TYPO3\Form\Exception\FinisherException('The option "recipientAddress" must be set for the EmailFinisher.', 1327060200);
		}
		if ($senderAddress === NULL) {
			throw new \TYPO3\Form\Exception\FinisherException('The option "senderAddress" must be set for the EmailFinisher.', 1327060210);
		}

		// create message
		$formRuntime = $this->finisherContext->getFormRuntime();
		$standaloneView = $this->initializeStandaloneView();
		$standaloneView->assignMultiple(array(
			'form' => $formRuntime,
			'recipientAddress' => $recipientAddress,
			'recipientName' => $recipientName
		));
		$message = $standaloneView->render();

		$mail = new \TYPO3\SwiftMailer\Message();

		$mail
			->setFrom(array($senderAddress => $senderName))
			->setTo(array($recipientAddress => $recipientName))
			->setSubject($subject);

		if ($replyToAddress !== NULL) {
			$mail->setReplyTo($replyToAddress);
		}

		if ($format === self::FORMAT_PLAINTEXT) {
			$mail->setBody($message, 'text/plain');
		} else {
			$mail->setBody($message, 'text/html');
		}

		if ($testMode === TRUE) {
			\TYPO3\Flow\var_dump(
				array(
					'sender' => array($senderAddress => $senderName),
					'recipient' => array($recipientAddress => $recipientName),
					'replyToAddress' => $replyToAddress,
					'message' => $message,
					'format' => $format,
				),
				'E-Mail "' . $subject . '"'
			);
		} else {
			$mail->send();
		}
	}

	/**
	 * @return string|null
	 */
	protected function getRecipientAddress() {
		$recipientAddress = $this->parseOption('recipientAddress');

		if ($recipientAddress === NULL) {
			$recipientNode = $this->getRecipientNode();
			$recipientNodeAddressProperty = $this->parseOption('recipientNodeAddressProperty');

			if ($recipientNodeAddressProperty === NULL) {
				$recipientAddress = $this->getRecipientAddressFromNode($recipientNode);
			} else {
				$recipientAddress = $this->getRecipientAddressFromNode($recipientNode, $recipientNodeAddressProperty);
			}
		}

		return $recipientAddress;
	}

	/**
	 * @return mixed|null
	 */
	protected function getRecipientName() {
		$recipientName = $this->parseOption('recipientName');

		if ($recipientName === NULL || $recipientName === '') {
			$recipientName = $this->getRecipientNameFromNode($this->getRecipientNode());
		}

		return $recipientName;
	}

	/**
	 * @param NodeInterface $node
	 * @param string $emailPropertyName
	 * @return mixed|null
	 * @throws \TYPO3\Flow\Property\Exception\InvalidPropertyException
	 */
	protected function getRecipientAddressFromNode(NodeInterface $node, $emailPropertyName = 'email') {
		try {
			if (!$node->hasProperty($emailPropertyName)) {
				throw new InvalidPropertyException('Property ' . $emailPropertyName . ' of Node ' . $node->getPath() . ' does not exist.', 1417712574);
			}

			$recipientAddress = $node->getProperty($emailPropertyName);
		} catch(\TYPO3\TYPO3CR\Exception\NodeException $e) {
			$recipientAddress = NULL;
		}

		return $recipientAddress;
	}

	/**
	 * @param NodeInterface $node
	 * @return mixed|string
	 */
	protected function getRecipientNameFromNode(NodeInterface $node) {
		if ($node->hasProperty('firstName') && $node->hasProperty('lastName')) {
			$recipientName = $node->getProperty('firstName') . ' ' . $node->getProperty('lastName');
		} else {
			$recipientName = $node->getProperty('title');
		}

		return $recipientName;
	}

	/**
	 * @return \TYPO3\TYPO3CR\Domain\Model\Node
	 */
	protected function getRecipientNode() {
		$formRuntime = $this->finisherContext->getFormRuntime();
		$renderingOptions = $formRuntime->getFormDefinition()->getRenderingOptions();
		$recipientNodeIdentifier = $this->parseOption('recipientNodeIdentifier');

		$q = new FlowQuery(array($renderingOptions['siteNode']));
		return $q->find('#' . $recipientNodeIdentifier)->get(0);
	}
}
