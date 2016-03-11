<?php
/**
 * Block edit template
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<article class="block-setting-body">
	<?php echo $this->BlockTabs->main(BlockTabsHelper::MAIN_TAB_BLOCK_INDEX); ?>

	<div class="tab-content">
		<?php echo $this->BlockTabs->block(BlockTabsHelper::BLOCK_TAB_SETTING); ?>

		<?php echo $this->element('Blocks.edit_form', array(
				'model' => 'PhotoAlbum',
				'callback' => 'PhotoAlbums.PhotoAlbumBlocks/edit_form',
				'cancelUrl' => NetCommonsUrl::backToIndexUrl('default_setting_action'),
			)); ?>

		<?php if ($this->request->params['action'] === 'edit') : ?>
			<?php echo $this->element('Blocks.delete_form', array(
					'model' => 'PhotoAlbumBlock',
					'action' => NetCommonsUrl::actionUrl(array(
						'controller' => $this->params['controller'],
						'action' => 'delete',
						'block_id' => Current::read('Block.id'),
						'frame_id' => Current::read('Frame.id')
					)),
					'callback' => 'PhotoAlbums.PhotoAlbumBlocks/delete_form'
				)); ?>
		<?php endif; ?>
	</div>
</article>