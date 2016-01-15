<?php

/** @var $deployment \TYPO3\Surf\Domain\Model\Deployment */

// configure node
$node = new \TYPO3\Surf\Domain\Model\Node('staging.international14.de');
$node->setHostname('international14.de');
$node->setOption('username', 'int14');
$node->setOption('webserverUsername', 'www-data');
$node->setOption('webserverGroupname', 'www-data');
$node->setOption('composerCommandPath', '/usr/local/bin/composer.phar');

// configure application
$application = new \TYPO3\Surf\Application\TYPO3\Neos();
$application->setDeploymentPath('/var/www/vhosts/ger.international14.org/staging.international14.de/');
$application->setOption('repositoryUrl', 'github.com/ger4003/neos-int14.git');
$application->setOption('typo3.surf:gitCheckout[branch]', 'neos-update');
$application->setOption('keepReleases', 3);
$application->setOption('transferMethod', 'rsync');
$application->setOption('packageMethod', 'git');
$application->setOption('updateMethod', NULL);
$application->setOption('sitePackageKey', 'Skail.Int14Ger');
$application->addNode($node);

// configure workflow
$workflow = new \TYPO3\Surf\Domain\Model\SimpleWorkflow();
// Disable rollback for inspection of deployment errors
$workflow->setEnableRollback(FALSE);

// configure deployment
$deployment->setWorkflow($workflow);
$deployment->addApplication($application);
$deployment->onInitialize(function() use ($deployment) {
	$workflow = $deployment->getWorkflow();

	// disable content deployment
	$workflow->removeTask('typo3.surf:typo3:neos:importsite');
	// you can't run a command with "sudo" at shared hosting environments
	$workflow->removeTask('typo3.surf:typo3:flow:setfilepermissions');

	// define additional tasks
	$workflow->defineTask('skail.int14ger:local:assets-compile', 'typo3.surf:localshell', array('command' => "cd '{workspacePath}' && ./publishassets.sh"));
	$workflow->defineTask('skail.int14ger:symlinkSharedWeb', 'typo3.surf:shell', array('command' => 'test -d "{sharedPath}/Web/" && find "{sharedPath}/Web/" -maxdepth 1 -mindepth 1 -exec sh -c "( [ ! -e {releasePath}/Web/{} ] && (ln -s {} {releasePath}/Web/ ) )" \;'));

	// run on local
	$workflow->beforeStage('transfer', array(
		'skail.int14ger:local:assets-compile'
	));

	// run on remote
//	$workflow->afterStage('update', array(
//		'skail.int14ger:symlinkSharedWeb'
//	));
});
