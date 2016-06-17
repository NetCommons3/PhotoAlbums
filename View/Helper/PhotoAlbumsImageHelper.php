<?php
/**
 * PhotoAlbums Image Helper class file.
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppHelper', 'View/Helper');

/**
 * PhotoAlbumsImageHelper
 *
 *
 */
class PhotoAlbumsImageHelper extends AppHelper {

/**
 * Other helpers
 *
 * @var array
 */
	public $helpers = array(
		'Html',
	);

/**
 * Creates jacket image url
 *
 * @param array $data PhotoAlbumAlbum data
 * @param string $size thumb, small, medium, big
 * @return form tag with approve button
 */
	public function jacketUrl($data, $size = null) {
		return $this->Html->url(
			$this->jacketUrlArray($data, $size)
		);
	}

/**
 * Creates jacket image url array
 *
 * @param array $data PhotoAlbumAlbum data
 * @param string $size thumb, small, medium, big
 * @return form tag with approve button
 */
	public function jacketUrlArray($data, $size = null) {
		return array(
			'plugin' => 'photo_albums',
			'controller' => 'photo_albums',
			'action' => 'jacket',
			Current::read('Block.id'),
			$data['PhotoAlbum']['id'],
			$size
		);
	}

/**
 * Creates photo image tag
 *
 * @param array $data PhotoAlbumAlbumPhoto data
 * @param string $size thumb, small, medium, big
 * @return form tag with approve button
 */
	public function photoImage($data, $size = null) {
		return $this->Html->image(
			$this->photoUrlArray($data, $size),
			array(
				'alt' => __d('photo_albums', 'Photo')
			)
		);
	}

/**
 * Creates photo image url
 *
 * @param array $data PhotoAlbumAlbumPhoto data
 * @param string $size thumb, small, medium, big
 * @return form tag with approve button
 */
	public function photoUrl($data, $size = null) {
		return $this->Html->url(
			$this->photoUrlArray($data, $size)
		);
	}

/**
 * Creates photo image url array
 *
 * @param array $data PhotoAlbumAlbumPhoto data
 * @param string $size thumb, small, medium, big
 * @return form tag with approve button
 */
	public function photoUrlArray($data, $size = null) {
		return array(
			'controller' => 'photo_album_photos',
			'action' => 'photo',
			Current::read('Block.id'),
			$data['PhotoAlbumPhoto']['album_key'],
			$data['PhotoAlbumPhoto']['id'],
			$size
		);
	}
}
