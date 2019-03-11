<?php
/**
 * PhotoAlbumBlockRolePermissionsControllerEdit  Test Case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('BlockRolePermissionsControllerEditTest', 'Blocks.TestSuite');

/**
 * Summary for PhotoAlbumBlockRolePermissionsControllerEdit  Test Case
 *
 */
class PhotoAlbumBlockRolePermissionsControllerEditTest extends BlockRolePermissionsControllerEditTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.photo_albums.block_setting_for_photo_album',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'photo_albums';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'photo_album_block_role_permissions';

/**
 * 権限設定で使用するFieldsの取得
 *
 * @return array
 */
	private function __approvalFields() {
		$data = array(
			'PhotoAlbumSetting' => array(
				'use_workflow',
				'approval_type',
			)
		);

		return $data;
	}

/**
 * テストDataの取得
 *
 * @return array
 */
	private function __data() {
		$data = array(
			'PhotoAlbum' => array(
				'id' => 2,
				'blog_key' => 'blog_key_2',
				'use_workflow' => '1',
				'use_comment_approval' => '1',
				'approval_type' => '1',
			)
		);

		return $data;
	}

/**
 * edit()アクションDataProvider
 *
 * ### 戻り値
 *  - approvalFields コンテンツ承認の利用有無のフィールド
 *  - exception Exception
 *  - return testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderEditGet() {
		return array(
			array('approvalFields' => $this->__approvalFields()),
		);
	}

/**
 * edit()アクションDataProvider
 *
 * ### 戻り値
 *  - data POSTデータ
 *  - exception Exception
 *  - return testActionの実行後の結果
 *
 * @return array
 */
	public function dataProviderEditPost() {
		return array(
			array('data' => $this->__data())
		);
	}

/**
 * test Post でのsaveBlogSetting 失敗
 *
 * @param array $data saveデータ
 * @return void
 * @dataProvider dataProviderEditPost
 */
	public function testSaveBlogSettingFail($data) {
		$this->_mockForReturnFalse('PhotoAlbums.PhotoAlbumSetting', 'savePhotoAlbumSetting');

		$result = $this->testEditPost($data, false, 'view');
		$approvalFields = $this->__approvalFields();
		$this->_assertEditGetPermission($approvalFields, $result);
	}

}
