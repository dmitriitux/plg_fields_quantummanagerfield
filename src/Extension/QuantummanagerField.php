<?php

namespace Joomla\Plugin\Fields\QuantumManagerField\Extension;

defined('_JEXEC') or die;

use DOMElement;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;
use Joomla\Component\Fields\Administrator\Plugin\FieldsPlugin;

/**
 * QuantummanagerField plugin.
 *
 * @package   quantummanagerfield
 * @since     2.0.0
 */
class QuantummanagerField extends FieldsPlugin
{

	/**
	 * Returns the custom fields types.
	 *
	 * @return  string[][]
	 *
	 * @since   3.7.0
	 */
	public function onCustomFieldsGetTypes()
	{
		// Cache filesystem access / checks
		static $types_cache = [];

		if (isset($types_cache[$this->_type . $this->_name]))
		{
			return $types_cache[$this->_type . $this->_name];
		}

		$types = [];

		// The root of the plugin
		$root = realpath(JPATH_PLUGINS . '/' . $this->_type . '/' . $this->_name);

		$layout = 'quantummanagerfield';

		// Strip the extension
		$layout = str_replace('.php', '', $layout);

		// The data array
		$data = [];

		// The language key
		$key = strtoupper($layout);

		if ($key != strtoupper($this->_name))
		{
			$key = strtoupper($this->_name) . '_' . $layout;
		}

		// Needed attributes
		$data['type'] = $layout;

		if (Factory::getLanguage()->hasKey('PLG_FIELDS_' . $key . '_LABEL'))
		{
			$data['label'] = Text::sprintf('PLG_FIELDS_' . $key . '_LABEL', strtolower($key));

			// Fix wrongly set parentheses in RTL languages
			if (Factory::getLanguage()->isRTL())
			{
				$data['label'] = $data['label'] . '&#x200E;';
			}
		}
		else
		{
			$data['label'] = $key;
		}

		$path = $root . '/fields';

		// Add the path when it exists
		if (file_exists($path))
		{
			$data['path'] = $path;
		}

		$path = $root . '/rules';

		// Add the path when it exists
		if (file_exists($path))
		{
			$data['rules'] = $path;
		}

		$types[] = $data;

		// Add to cache and return the data
		$types_cache[$this->_type . $this->_name] = $types;

		return $types;
	}

	public function onCustomFieldsPrepareDom($field, DOMElement $parent, Form $form)
	{

		$fieldNode = parent::onCustomFieldsPrepareDom($field, $parent, $form);
		if (!$fieldNode)
		{
			return $fieldNode;
		}

		$fieldNode->setAttribute('addfieldprefix', 'Joomla\\Plugin\\Fields\\QuantumManagerField\\Field');

		return $fieldNode;
	}

}
