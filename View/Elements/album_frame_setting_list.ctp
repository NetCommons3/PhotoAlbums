<?php
/**
 * PhotoAlbum album frame list template
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<div class="photo-albums-frame-setting-list">
	<table class="table photo-albums-setting-list">
		<thead>
			<tr>
				<th>
					<?php
						echo $this->Form->input(
							'CheckAll',
							array(
								'type' => 'checkbox',
								'name' => false,
								'secure' => false,
								'checked' => false,
								'label' => false,
								'div' => false,
								'class' => false,
								'hiddenField' => false,
								'ng-model' => 'FrameSettingController.checkedAll',
								'ng-click' => 'FrameSettingController.checkAll()',
								'ng-disabled' => 'FrameSettingController.displayType != ' . PhotoAlbumFrameSetting::DISPLAY_TYPE_ALBUMS,
								'ng-hide' => 'FrameSettingController.displayType != ' . PhotoAlbumFrameSetting::DISPLAY_TYPE_ALBUMS
							)
						);
					?>
				</th>
				<th>
					<a href="" ng-click="FrameSettingController.sortBy('PhotoAlbum.name')">
						<?php echo __d('photo_albums', 'Album Name'); ?>
					</a>
				</th>
				<th>
					<a href="" ng-click="FrameSettingController.sortBy('PhotoAlbum.status')">
						<?php echo __d('photo_albums', 'Status'); ?>
					</a>
				</th>
				<th>
					<a href="" ng-click="FrameSettingController.sortBy('PhotoAlbum.latest_photo_count')">
						<?php echo __d('photo_albums', 'Photo'); ?>
					</a>
				</th>
			</tr>
		</thead>

		<tbody>
			<tr ng-class="{active: false}" ng-repeat="(index, album) in FrameSettingController.albums | orderBy:FrameSettingController.propertyName:FrameSettingController.reverse">
				<td>
					<?php
						echo $this->Form->input(
							'PhotoAlbumDisplayAlbum..album_key',
							array(
								'type' => 'checkbox',
								'label' => false,
								'div' => false,
								'class' => false,
								'hiddenField' => false,
								'ng-value' => 'album.PhotoAlbum.key',
								'ng-hide' => 'FrameSettingController.displayType != ' . PhotoAlbumFrameSetting::DISPLAY_TYPE_ALBUMS,
								'ng-disabled' => 'FrameSettingController.displayType != ' . PhotoAlbumFrameSetting::DISPLAY_TYPE_ALBUMS,
								'ng-checked' => "FrameSettingController.displayAlbumKeys.indexOf(album.PhotoAlbum.key) > -1",
							)
						);

						$this->Form->unlockField('PhotoAlbumDisplayAlbum..album_key');
						$this->Form->unlockField('PhotoAlbumDisplayAlbum.album_key');
						echo $this->Form->input(
							'PhotoAlbumDisplayAlbum..album_key',
							array(
								'type' => 'radio',
								'options' => array(''),
								'label' => false,
								'div' => false,
								'class' => false,
								'hiddenField' => false,
								'ng-value' => 'album.PhotoAlbum.key',
								'ng-hide' => 'FrameSettingController.displayType == ' . PhotoAlbumFrameSetting::DISPLAY_TYPE_ALBUMS,
								'ng-disabled' => 'FrameSettingController.displayType == ' . PhotoAlbumFrameSetting::DISPLAY_TYPE_ALBUMS,
								'ng-checked' => "album.PhotoAlbum.key == '" . $displayAlbumKeys[0] . "'",
							)
						);
					?>
				</td>

				<td>
					<div class="thumbnail photo-albums-setting-thumbnail">
						<?php
							echo $this->Html->image(
								'PhotoAlbums.noimage.gif',
								array(
									'alt' => __d('photo_albums', 'jacket'),
									'class' => 'img-responsive photo-albums-jacket',
									'ng-hide' => 'album.UploadFile.jacket.id',
								)
							);

							$srcPrefix = $this->Html->url(
								array(
									'plugin' => 'photo_albums',
									'controller' => 'photo_albums',
									'action' => 'jacket',
									Current::read('Block.id'),
								)
							);
						?>
						<img
							class="img-responsive photo-albums-jacket"
							alt="<?php echo __d('photo_albums', 'jacket'); ?>"
							ng-src="{{album.UploadFile.jacket.id ? ('<?php echo $srcPrefix ?>/' + album.PhotoAlbum.id + '/small') : null}}"
							ng-hide="!album.UploadFile.jacket.id"
						>
					</div>

					<div class="photo-albums-name">
						{{album.PhotoAlbum.name}}
					</div>
				</td>

				<td>
					<span ng-switch="album.PhotoAlbum.status">
						<span class="workflow-label label label-info" ng-switch-when="<?php echo WorkflowComponent::STATUS_IN_DRAFT ?>">
							<?php echo __d('net_commons', 'Temporary'); ?>
						</span>
						<span class="workflow-label label label-warning" ng-switch-when="<?php echo WorkflowComponent::STATUS_APPROVAL_WAITING ?>">
							<?php echo __d('net_commons', 'Approving'); ?>
						</span>
						<span class="workflow-label label label-danger" ng-switch-when="<?php echo WorkflowComponent::STATUS_DISAPPROVED ?>">
							<?php echo __d('net_commons', 'Disapproving'); ?>
						</span>
					</span>
				</td>

				<td class="nc-table-numeric">
					{{album.PhotoAlbum.latest_photo_count}}
				</td>
			</tr>
		</tbody>
	</table>
</div>
