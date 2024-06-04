<?php defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\Component\QuantumManager\Administrator\Helper\QuantummanagerLibsHelper;

extract($displayData);

QuantummanagerLibsHelper::theme();
$modalHTML  = '';
$modal_id = 'imageModalQuantumuploadimage_' . random_int(111111, 999999);

HTMLHelper::_('stylesheet', 'com_quantummanager/joomla.css', [
	'version'  => filemtime(__FILE__),
	'relative' => true
]);

try
{
	$modalHTML = HTMLHelper::_(
		'bootstrap.renderModal',
		$modal_id,
		[
			'url'         => 'index.php?option=com_quantummanager&tmpl=component&layout=modal&namespace=quantumuploadimage',
			'title'       => Text::_('JLIB_FORM_CHANGE_IMAGE'),
			'closeButton' => true,
			'height'      => '100%',
			'width'       => '100%',
			'modalWidth'  => '80',
			'bodyHeight'  => '80',
			'footer'      => '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">' . Text::_('JCANCEL') . '</button>',
		]
	);
}
catch (Exception $e)
{
}

HTMLHelper::_('stylesheet', 'lib_fields/quantumuploadimage/field.css', [
	'version'  => filemtime(__FILE__),
	'relative' => true
]);

HTMLHelper::_('script', 'lib_fields/quantumuploadimage/field.js', [
	'version'  => filemtime(__FILE__),
	'relative' => true
]);

$app   = Factory::getApplication();
$img   = !empty($displayData['value']) ? '/' . $displayData['value'] : '';
$value = $displayData['value'];

$app->getSession()->set('quantummanageraddscripts', json_encode([
	'lib_fields/quantumuploadimage/quantummodal.js'
]), 'quantumuploadimage');

$quantumOptions = [
	'option'     => 'com_quantummanager',
	'tmpl'       => 'component',
	'layout'     => 'modal',
	'namespace'  => 'quantumuploadimage'
];

?>

<div class="quantumuploadimage-field-toolbar <?php if (isset($displayData['dropAreaHidden']) && (int) $displayData['dropAreaHidden']) : ?>quantumuploadimage-preview-hidden<?php endif; ?>">
    <div class="quantumuploadimage-preview <?php if (!empty($img)) : ?>quantumuploadimage-preview-active<?php endif; ?>">
		<?php if (!empty($img)) : ?>
            <img src="<?php echo $img ?>"/>
		<?php endif; ?>
    </div>
    <div class="quantumuploadimage-actions">
        <input type="text" name="<?php echo $displayData['name'] ?>" id="<?php echo $displayData['id'] ?>"
               value="<?php echo $value ?>"
               class="quantumuploadimage-input form-control">
        <div class="quantumuploadimage-group-buttons">
			<?php if (isset($displayData['dropAreaHidden']) && (int) $displayData['dropAreaHidden']) : ?>
                <button class="qm-btn quantumuploadimage-upload-start"><?php echo Text::_('COM_QUANTUMMANAGER_ACTION_UPLOADING') ?></button><?php endif; ?>
            <button class="qm-btn qm-btn-primary quantumuploadimage-change"
                    aria-hidden="true"
                    data-source-href="/administrator/index.php?<?php echo http_build_query($quantumOptions) ?>"
                    data-modal-id="<?php echo $modal_id; ?>"
            ><?php echo Text::_('COM_QUANTUMMANAGER_ACTION_SELECT') ?></button>
			<?php if ((int) $displayData['copy']) : ?>
                <button class="qm-btn quantumuploadimage-copy only-icon" aria-hidden="true"><span
                            class="icon-copy"></span></button><?php endif; ?>
            <button class="qm-btn qm-btn-danger quantumuploadimage-delete only-icon" aria-hidden="true"><span
                        class="icon-remove"></span></button>
        </div>
    </div>
	<?php echo $modalHTML; ?>
</div>