<?php
/**
 * PhotoAlbumsSettingUtility
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * PhotoAlbumsSettingUtility
 *
 * FrameのSettingから、 PhotoAlbumsController、PhotoAlbumPhotosControllerのアクション
 * を呼び出されていた場合のURL処理を行います。
 *
 */
class PhotoAlbumsSettingUtility {

/**
 * Constant for setting word
 *
 * @var int
 */
	const SETTING_WORD = 'setting';

/**
 * True if frame setting
 *
 * @var int
 */
	private static $__isSetting = null;

/**
 * Returns true if frame setting.
 *
 * @return bool True if frame setting.
 */
	public static function isSetting() {
		if (isset(self::$__isSetting)) {
			return self::$__isSetting;
		}

		$request = Router::getRequest(true);
		self::$__isSetting = (
			$request->params['action'] == 'setting' ||
			end($request->params['pass']) == self::SETTING_WORD ||
			(isset($request->params['key']) &&
				$request->params['key'] === self::SETTING_WORD)
		);

		return self::$__isSetting;
	}

/**
 * Add SETTING_WORD if frame setting.
 *
 * @param array $url url
 * @return array
 */
	public static function settingUrl($url) {
		if (self::isSetting()) {
			$url[] = self::SETTING_WORD;
		}

		return $url;
	}
}
