<?php
namespace Skail\Int14Ger\ViewHelpers;

/***************************************************************
 *  (c) 2015 networkteam GmbH - all rights reserved
 ***************************************************************/

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\I18n\Formatter\DatetimeFormatter;
use TYPO3\Flow\Property\Exception\InvalidPropertyException;
use TYPO3\Fluid\Core\ViewHelper\Exception as ViewHelperException;
use TYPO3\Flow\I18n\Exception as I18nException;

class DateGroupViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractLocaleAwareViewHelper {

	
	/**
	 * NOTE: This property has been introduced via code migration to ensure backwards-compatibility.
	 * @see AbstractViewHelper::isOutputEscapingEnabled()
	 * @var boolean
	 */
	protected $escapeOutput = FALSE;

	/**
	 * @Flow\Inject
	 * @var DatetimeFormatter
	 */
	protected $datetimeFormatter;

	/**
	 * @param \TYPO3\Flow\Persistence\QueryResultInterface $objects
	 * @param string $groupBy name of DateTime property to group by
	 * @param string $format DateTime format
	 * @param string $localeFormatType Whether to format (according to locale set in $forceLocale) date, time or datetime. Must be one of TYPO3\Flow\I18n\Cldr\Reader\DatesReader::FORMAT_TYPE_*'s constants.
	 * @param string $localeFormatLength Format length if locale set in $forceLocale. Must be one of TYPO3\Flow\I18n\Cldr\Reader\DatesReader::FORMAT_LENGTH_*'s constants.
	 * @param string $cldrFormat Format string in CLDR format (see http://cldr.unicode.org/translation/date-time)
	 * @return mixed
	 * @throws \TYPO3\Fluid\Core\ViewHelper\Exception\InvalidVariableException
	 */
	public function render(\TYPO3\Flow\Persistence\QueryResultInterface $objects, $groupBy, $format = 'F Y', $localeFormatType = NULL, $localeFormatLength = NULL, $cldrFormat = NULL) {
		$groups = array();
		foreach($objects as $object) {
			/** @var \TYPO3\TYPO3CR\Domain\Model\Node $object */
			/** @var \DateTime $startDate */
			if ($object->hasProperty($groupBy)) {
				$date = $object->getProperty($groupBy);
				if (!$date instanceof \DateTime) {
					try {
						$date = new \DateTime($date);
					} catch (\Exception $exception) {
						throw new ViewHelperException('"' . $date . '" could not be parsed by \DateTime constructor.', 1438370516, $exception);
					}
				}

				$useLocale = $this->getLocale();
				if ($useLocale !== NULL) {
					try {
						if ($cldrFormat !== NULL) {
							$output = $this->datetimeFormatter->formatDateTimeWithCustomPattern($date, $cldrFormat, $useLocale);
						} else {
							$output = $this->datetimeFormatter->format($date, $useLocale, array($localeFormatType, $localeFormatLength));
						}
					} catch(I18nException $exception) {
						throw new ViewHelperException(sprintf('An error occurred while trying to format the given date/time: "%s"', $exception->getMessage()), 1342610987, $exception);
					}
				} else {
					$output = $date->format($format);
				}

				$groups[$output][] = $object;


			} else {
				throw new InvalidPropertyException("Property $groupBy is not supportet by $object", 1426867196);
			}
		}

		$this->renderingContext->getTemplateVariableContainer()->add('groups', $groups);

		return $this->renderChildren();
	}
}