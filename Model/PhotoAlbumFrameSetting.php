<?php
/**
 * PhotoAlbumFrameSetting Model
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PhotoAlbumsAppModel', 'PhotoAlbums.Model');

/**
 * Summary for PhotoAlbumFrameSetting Model
 */
class PhotoAlbumFrameSetting extends PhotoAlbumsAppModel {
/**
 * Constant for display type
 *
 * @var int
 */
	const DISPLAY_TYPE_ALBUMS = 1;
	const DISPLAY_TYPE_PHOTOS = 2;
	const DISPLAY_TYPE_SLIDE = 3;

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';

/**
 * List of behaviors
 *
 * @var array
 */
	public $actsAs = array(
			'Frames.FrameSetting',
	);

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/ja/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate, array(
			// TODO frame_keyのチェックいる？
			'frame_key' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				),
			),
			'albums_per_page' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				),
			),
			'photos_per_page' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true,
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * Save PhotoAlbumFrameSetting
 *
 * @param array $data received post data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 * @throws InternalErrorException
 */
	public function savePhotoAlbumFrameSetting($data) {
		$this->begin();

		$this->set($data['PhotoAlbumFrameSetting']);
		if (! $this->validates()) {
			$this->rollback();
			return false;
		}

		try {
			if (! $videoFrameSetting = $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			// TODO 不正なアルバムキーバリデーション
			$displayAlbum = ClassRegistry::init('PhotoAlbums.PhotoAlbumDisplayAlbum', true);

			$conditions = array('frame_key' => $data['PhotoAlbumFrameSetting']['frame_key']);
			if (!$displayAlbum->deleteAll($conditions, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if (empty($data['PhotoAlbumDisplayAlbum'])) {
				$data['PhotoAlbumDisplayAlbum'] = array();
			}
			foreach ($data['PhotoAlbumDisplayAlbum'] as $displayAlbum) {
				$displayAlbum['frame_key'] = $data['PhotoAlbumFrameSetting']['frame_key'];
				if (!$displayAlbum->saveDisplayAlbum($displayAlbum)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
				}
			}

			$this->commit();

		} catch (Exception $ex) {
			$this->rollback($ex);
		}

		return $videoFrameSetting;
	}
}
