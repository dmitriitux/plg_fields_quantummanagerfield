<?php

namespace Joomla\Plugin\Fields\QuantumManagerField\Field;

defined('_JEXEC') or die;

use Joomla\CMS\Form\FormField;
use Joomla\CMS\Factory;
use Joomla\Component\QuantumManager\Administrator\Helper\QuantummanagerHelper;
use Joomla\Component\QuantumManager\Administrator\Field\QuantumcombineField;
use SimpleXMLElement;

/**
 * Class QuantummanagerfieldField
 */
class QuantummanagerfieldField extends FormField
{

	/**
	 * @var string
	 */
	public $type = 'QuantumManagerField';

	public function getLabel()
	{
		return parent::getLabel(); // TODO: Change the autogenerated stub
	}

	public function getInput()
	{
		$db    = Factory::getDBO();
		$query = $db->getQuery(true)
			->select($db->quoteName(array('params', 'fieldparams')))
			->from('#__fields')
			->where('name=' . $db->quote($this->fieldname));
		$field = $db->setQuery($query)->loadObject();

		$fieldparams = json_decode($field->fieldparams, JSON_OBJECT_AS_ARRAY);

		$folderRoot                = $fieldparams['path'];
		$optionsForField['layout'] = 'quantummanagerfield';
		$optionsForField['fields'] = json_encode([
			'quantumupload' => [
				'maxsize'        => QuantummanagerHelper::getParamsComponentValue('maxsize', '10'),
				'dropAreaHidden' => '0',
				'directory'      => $folderRoot,
				'scope'          => $fieldparams['scope']
			]
		]);

		$data = $this->getLayoutData();

		$dataAttributes = array_map(static function ($value, $key) {
			return $key . "='" . $value . "'";
		}, array_values($optionsForField), array_keys($optionsForField));

		$fieldObject = new QuantumcombineField;
		$fieldObject->setup(new SimpleXMLElement('<field name="' . $data['name'] . '" value="' . $data['value'] . '" type="quantumcombine" ' . implode(' ', $dataAttributes) . ' />'), '');
		$fieldObject->value = $data['value'];
		$fieldObject->addCustomLayoutsPath([JPATH_ROOT . '/layouts/fields/quantummanagerfield']);

		$html = $fieldObject->getInput();

		return $html;
	}

}