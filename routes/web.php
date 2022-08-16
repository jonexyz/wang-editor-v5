<?php
use Jonexyz\WangEditorV5\Http\Controllers\UploadsController;

Route::post('wangeditorv5_img_upload', UploadsController::class.'@img');

Route::post('wangeditorv5_video_upload', UploadsController::class.'@video');
