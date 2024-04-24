<?php
/**
 * @package    quantummanager
 * @author     Dmitry Tsymbal <cymbal@delo-design.ru>
 * @copyright  Copyright © 2019 Delo Design & NorrNext. All rights reserved.
 * @license    GNU General Public License version 3 or later; see license.txt
 * @link       https://www.norrnext.com
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\FileLayout;

defined('_JEXEC') or die;
extract($displayData);

HTMLHelper::_('script', 'plg_fields_quantummanagerfield/field.js', [
	'version'  => filemtime(__FILE__),
	'relative' => true
]);
?>

<div class="quantumcombineselectfile">

	<div class="preview-file" data-value="<?php echo $displayData['value'] ?>">

		<div class="uk-flex" data-uk-form-custom>
			<div data-uk-lightbox="toggle: .uk-button">
				<div class="uk-button uk-button-default preview" href=""><i data-uk-icon="icon: image"></i></div>
			</div>
			<input class="input-file uk-input <?php echo $displayData['class'] ?>" type="text" name="<?php echo $displayData['name'] ?>" id="<?php echo $displayData['id'] ?>" value="<?php echo $displayData['value'] ?>" style="width: 300px" />
			<div class="change-button uk-button uk-button-primary">Изменить</div>
		</div>

	</div>

	<div style="display: none">
		<?php
		$template = new FileLayout('quantumcombine', JPATH_ROOT . '/administrator/components/com_quantummanager/layouts');
		echo $template->render($displayData);
		?>
	</div>

</div>