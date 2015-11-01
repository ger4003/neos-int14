<?php
namespace Skail\Int14Ger\Form\FormElements;

use TYPO3\Eel\FlowQuery\FlowQuery;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Property\Exception\InvalidPropertyException;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;


class SingleNodeSelectDropdown extends \TYPO3\Form\Core\Model\AbstractFormElement {

	/**
	 * @param \TYPO3\Form\Core\Runtime\FormRuntime $formRuntime
	 * @throws \TYPO3\Flow\Property\Exception\InvalidPropertyException
	 */
	public function beforeRendering(\TYPO3\Form\Core\Runtime\FormRuntime $formRuntime) {
		$renderingOptions = $this->getRootForm()->getRenderingOptions();

		if (isset($renderingOptions['siteNode']) && $renderingOptions['siteNode'] instanceof NodeInterface) {
			$q = new FlowQuery(array($renderingOptions['siteNode']));
			$optionNodes = $q->find('[instanceof ' . $this->properties['optionNodeType'] . ']');
			$options = array();

			// prepend option
			if (isset($this->properties['prependOptionLabel'])) {
				$prependOptionValue = isset($this->properties['prependOptionValue']) ? $this->arguments['prependOptionValue'] : '';
				$options[htmlspecialchars($prependOptionValue)] = htmlspecialchars($this->properties['prependOptionLabel']);
			}

			foreach ($optionNodes as $node) {
				/** @var \TYPO3\TYPO3CR\Domain\Model\Node $node */
				try {
					if (!$node->hasProperty($this->properties['optionLabelField'])) {
						throw new InvalidPropertyException('Property ' . $this->properties['optionLabelField'] . ' of Node ' . $node->getPath() . ' does not exist.', 1410528891);
					}

					if (isset($this->properties['optionValueField']) && $this->properties['optionValueField'] !== 'identifier') {
						if (!$node->hasProperty($this->properties['optionValueField'])) {
							throw new InvalidPropertyException('Property ' . $this->properties['optionValueField'] . ' of Node ' . $node->getPath() . ' does not exist.', 1410528891);
						}
						$key = $node->getProperty($this->properties['optionValueField']);
					} else {
						$key = $node->getIdentifier();
					}

					$options[htmlspecialchars($key)] = htmlspecialchars($node->getProperty($this->properties['optionLabelField']));
				} catch (\Exception $e) {

				}
			}

			$this->setProperty('options', $options);
		} else {
			throw new InvalidPropertyException('node is not set', 1410525720);
		}
	}
}