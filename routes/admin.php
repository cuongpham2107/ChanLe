<?php

use App\Http\Controllers\dgaAdmin\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['as' => 'admin.', 'middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\dgaAdmin\HomeController::class, 'thongke'])->name('home');
    Route::get('/home', [App\Http\Controllers\dgaAdmin\HomeController::class, 'thongke'])->name('home');
    Route::get('/statistics', [App\Http\Controllers\dgaAdmin\HomeController::class, 'statistics'])->name('statistics');
    Route::get('/history-week', [App\Http\Controllers\dgaAdmin\HomeController::class, 'historyofWeek'])->name('historyofWeek');
    Route::get('/overview', [App\Http\Controllers\dgaAdmin\HomeController::class, 'thongke'])->name('thongke');
    Route::get('/setting', [App\Http\Controllers\dgaAdmin\HomeController::class, 'setting'])->name('setting');
    Route::post('/setting', [App\Http\Controllers\dgaAdmin\HomeController::class, 'settingEdit'])->name('settingEdit');
    Route::get('/setting-game', [App\Http\Controllers\dgaAdmin\HomeController::class, 'settingGame'])->name('settingGame');
    Route::get('/setting-modal', [App\Http\Controllers\dgaAdmin\HomeController::class, 'settingTt'])->name('settingTt');
    Route::post('/setting-game', [App\Http\Controllers\dgaAdmin\HomeController::class, 'settingGamePost'])->name('settingGamePost');
    Route::post('/setting-modal', [App\Http\Controllers\dgaAdmin\HomeController::class, 'settingTtPost'])->name('settingTtPost');
    // Route::get('/add-momo', [App\Http\Controllers\dgaAdmin\MomoController::class, 'addMomo'])->name('addMomo');
    Route::get('/chuyen-tien-zalopay-v2', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'sendMomoV2'])->name('sendMomo');
    // Route::get('/list-momo', [App\Http\Controllers\dgaAdmin\MomoController::class, 'listMomo'])->name('listMomo');
    Route::post('/get-otp', [App\Http\Controllers\dgaAdmin\MomoController::class, 'getOTP'])->name('getOTP');
    // Route::post('/verify-momo', [App\Http\Controllers\dgaAdmin\MomoController::class, 'verifyMomo'])->name('verifyMomo');

    // Zalopay
    Route::get('/add-zalo', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'addZalo'])->name('addZalopay');
    Route::get('/chuyen-tien-zalo', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'sendZalopay'])->name('sendZalopay');
    Route::get('/list-zalo', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'listZalo'])->name('listZalo');
    Route::post('/get-otp-zalo', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'getOTPZalo'])->name('getOTPZalo');
    Route::post('/verify-zalo', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'verifyZalopay'])->name('verifyZalopay');
    Route::post('/login-zalo-one', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'loginZalopayOne'])->name('loginZalopayOne');
    Route::post('/get-balance-zalopay', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'getBalanceZalopay'])->name('getBalanceZalopay');


    Route::get('/login-zlp/{phone}', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'loginZlp'])->name('loginZlp');
    Route::post('/delete-zlp', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'deleteZlp'])->name('deleteZlp');
    Route::post('/active-zlp', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'activeZlp'])->name('activeZlp');
    Route::post('/hide-zlp', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'hideZlp'])->name('hideZlp');
    Route::post('/soak-zlp', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'soakZlp'])->name('soakZlp');
    Route::post('/maintenance-zlp', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'maintenanceZlp'])->name('maintenanceZlp');
    Route::post('/info-zlp', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'infoZlp'])->name('infoZlp');
    Route::post('/edit-zlp', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'editZlp'])->name('editZlp');

    Route::post('/login-all-zlp', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'loginAllZlp'])->name('loginAllZlp');

    // End
    // Route::get('/login-momo/{phone}', [App\Http\Controllers\dgaAdmin\MomoController::class, 'loginMomo'])->name('loginMomo');
    Route::post('/delete-momo', [App\Http\Controllers\dgaAdmin\MomoController::class, 'deleteMomo'])->name('deleteMomo');
    // Route::post('/active-momo', [App\Http\Controllers\dgaAdmin\MomoController::class, 'activeMomo'])->name('activeMomo');
    // Route::post('/hide-momo', [App\Http\Controllers\dgaAdmin\MomoController::class, 'hideMomo'])->name('hideMomo');
    // Route::post('/soak-momo', [App\Http\Controllers\dgaAdmin\MomoController::class, 'soakMomo'])->name('soakMomo');
    // Route::post('/set-lotteria-momo', [App\Http\Controllers\dgaAdmin\MomoController::class, 'setLotteriaMomo'])->name('setLotteriaMomo');
    // Route::post('/maintenance-momo', [App\Http\Controllers\dgaAdmin\MomoController::class, 'maintenanceMomo'])->name('maintenanceMomo');
    // Route::post('/info-momo', [App\Http\Controllers\dgaAdmin\MomoController::class, 'infoMomo'])->name('infoMomo');
    // Route::post('/edit-momo', [App\Http\Controllers\dgaAdmin\MomoController::class, 'editMomo'])->name('editMomo');
    Route::get('/history-play/{game}', [App\Http\Controllers\dgaAdmin\HistoryController::class, 'historyPlay'])->name('historyPlay');
    Route::get('/history-play-all', [App\Http\Controllers\dgaAdmin\HistoryController::class, 'historyPlayALL'])->name('historyPlayALL');
    Route::get('/history-play-error', [App\Http\Controllers\dgaAdmin\HistoryController::class, 'historyPlayError'])->name('historyPlayError');
    Route::post('/history-pay-error', [App\Http\Controllers\dgaAdmin\HistoryController::class, 'submitPayError'])->name('submitPayError');
    Route::get('/edit-history-bank/{tranId}/{name}/{phone}', [App\Http\Controllers\dgaAdmin\MomoController::class, 'editHistoryBank'])->name('admin.editHistoryBank');
    Route::get('/check-status', [App\Http\Controllers\dgaAdmin\MomoController::class, 'checkStatus'])->name('admin.checkStatus');
    Route::get('/delete-history-bank/{id}', [App\Http\Controllers\dgaAdmin\MomoController::class, 'deleteHistoryBank'])->name('admin.deleteHistoryBank');
    Route::get('/delete-history-play/{id}', [App\Http\Controllers\dgaAdmin\MomoController::class, 'deleteHistoryPlay'])->name('admin.deleteHistoryPlay');
    Route::get('/auto-reset-day', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'autoReset'])->name('autoReset');
    Route::get('/update-momo-count', [App\Http\Controllers\dgaAdmin\MomoController::class, 'updateMomoCount'])->name('admin.updateMomoCount');


    // Route::get('/edit-history-play/{tranId}/{comment}', [App\Http\Controllers\dgaAdmin\MomoController::class, 'editHistoryPlay'])->name('admin.editHistoryPlay');
    Route::get('/history-muster', [App\Http\Controllers\dgaAdmin\HistoryController::class, 'historyMuster'])->name('historyMuster');
    Route::get('/history-day-mission', [App\Http\Controllers\dgaAdmin\HistoryController::class, 'historyDayMission'])->name('historyDayMission');
    // Route::post('/login-all-momo', [App\Http\Controllers\dgaAdmin\MomoController::class, 'loginAllMomo'])->name('loginAllMomo');
    Route::post('/check-status-transfer', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'checkStatusTransfer'])->name('checkStatusTransfer');
    // Route::post('/login-momo-one', [App\Http\Controllers\dgaAdmin\MomoController::class, 'loginMomoOne'])->name('loginMomoOne');
    Route::get('/week-top', [App\Http\Controllers\dgaAdmin\HistoryController::class, 'weekTop'])->name('weekTop');
    Route::post('/pay-week-top', [App\Http\Controllers\dgaAdmin\HistoryController::class, 'payWeekTop'])->name('payWeekTop');
    Route::get('/history-bank', [App\Http\Controllers\dgaAdmin\HistoryController::class, 'historyBank'])->name('historyBank');
    Route::post('/send-money', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'sendMoney'])->name('sendMoney');
    Route::post('/cash-back', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'cashBack'])->name('cashBack');
    Route::get('/change-password', [App\Http\Controllers\dgaAdmin\HomeController::class, 'changePass'])->name('changePass');
    Route::post('/change-password', [App\Http\Controllers\dgaAdmin\HomeController::class, 'changePassPost'])->name('changePassPost');
    Route::post('/update', [App\Http\Controllers\dgaAdmin\HomeController::class, 'update'])->name('updateVer');
    Route::get('/support', [App\Http\Controllers\dgaAdmin\HomeController::class, 'support'])->name('support');
    Route::post('/support', [App\Http\Controllers\dgaAdmin\HomeController::class, 'supportPost'])->name('supportPost');
    Route::post('/edit-support', [App\Http\Controllers\dgaAdmin\HomeController::class, 'supportEdit'])->name('supportEdit');
    Route::post('/status-support', [App\Http\Controllers\dgaAdmin\HomeController::class, 'supportStatus'])->name('supportStatus');
    Route::get('/add-giftcode', [App\Http\Controllers\dgaAdmin\GiftCodeController::class, 'index'])->name('giftcode');
    Route::post('/add-giftcode', [App\Http\Controllers\dgaAdmin\GiftCodeController::class, 'giftcodePost'])->name('giftcodePost');
    Route::post('/edit-giftcode', [App\Http\Controllers\dgaAdmin\GiftCodeController::class, 'giftcodeEdit'])->name('giftcodeEdit');
    Route::post('/status-giftcode', [App\Http\Controllers\dgaAdmin\GiftCodeController::class, 'giftcodeStatus'])->name('giftcodeStatus');
    Route::get('/history-giftcode', [App\Http\Controllers\dgaAdmin\GiftCodeController::class, 'historyGiftCode'])->name('historyGiftCode');
    Route::get('/history-hu', [App\Http\Controllers\dgaAdmin\HistoryController::class, 'historyHu'])->name('historyHu');
    Route::get('/history-transfer-momo', [App\Http\Controllers\dgaAdmin\HistoryController::class, 'historyTransMomo'])->name('historyTransMomo');
    Route::get('/black-list', [App\Http\Controllers\dgaAdmin\HomeController::class, 'blackList'])->name('blackList');
    Route::post('/black-list', [App\Http\Controllers\dgaAdmin\HomeController::class, 'blackListPost'])->name('blackListPost');
    Route::post('/delete-black-list-momo', [App\Http\Controllers\dgaAdmin\HomeController::class, 'deleteMomoBlack'])->name('deleteMomoBlack');
    Route::get('/info-tran/{tran}/{full?}', [App\Http\Controllers\dgaAdmin\HistoryController::class, 'infoTran'])->name('infoTran');
    Route::get('/check-tran', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'checkTran'])->name('checkTran');
    Route::post('/check-tran-by-id', [App\Http\Controllers\dgaAdmin\MiniGame::class, 'checkTranById'])->name('checkTranById');
    Route::post('/info-tran/{tran}', [App\Http\Controllers\dgaAdmin\HistoryController::class, 'infoTranEdit'])->name('infoTranEdit');
    Route::post('/insert-bill', [App\Http\Controllers\dgaAdmin\HistoryController::class, 'insertNewHistory'])->name('insertNewHistory');
    Route::get('/add-bill', [App\Http\Controllers\dgaAdmin\HistoryController::class, 'addNewHistory'])->name('addNewHistory');

    Route::get('/setup-2fa', [HomeController::class, 'setup2fa'])->name('setup2fa');
    Route::post('/setup-2fa', [HomeController::class, 'setup2faPost'])->name('setup2faPost');

    // Route::get('/check-bank/{phone}/{bankCode}/{accountNo}', [App\Http\Controllers\dgaAdmin\MomoController::class, 'checkBank'])->name('checkBank');
    // Route::get('/chuyen-tien-qua-nh', [App\Http\Controllers\dgaAdmin\MomoController::class, 'sendBank'])->name('sendBank');
    // Route::post('/send-money-bank', [App\Http\Controllers\dgaAdmin\MomoController::class, 'sendMoneyBank'])->name('sendMoneyBank');

    // Route::get('/lotteria-history-all', [App\Http\Controllers\dgaAdmin\LotteriaController::class, 'historyPlayALL'])->name('lotteriaHistoryPlayALL');
    // Route::get('/lotteria-result', [App\Http\Controllers\dgaAdmin\LotteriaController::class, 'lotteriaResult'])->name('lotteriaResult');
    // Route::get('/lotteria-setting', [App\Http\Controllers\dgaAdmin\LotteriaController::class, 'settingGame'])->name('lotteriaSettingGame');
    // Route::post('/lotteria-setting', [App\Http\Controllers\dgaAdmin\LotteriaController::class, 'settingGamePost'])->name('lotteriaSettingGame');
    // Route::get('/lotteria-setting', [App\Http\Controllers\dgaAdmin\LotteriaController::class, 'settingGame'])->name('lotteriaSettingGame');
    // Route::get('/get-lotteria-result/{type_region}', [App\Http\Controllers\dgaAdmin\LotteriaController::class, 'getLotteriaResults'])->name('getLotteriaResults');
    // Route::get('/auto-pay-lotteria-bill', [App\Http\Controllers\dgaAdmin\LotteriaController::class, 'autoPayLotteriaBills'])->name('autoPayLotteriaBills');

    // Route::get('/normalized-provice-name', [App\Http\Controllers\dgaAdmin\LotteriaController::class, 'normalizeProvincesName'])->name('normalizeProvincesName');
});
Route::get('/login', [App\Http\Controllers\dgaAdmin\LoginController::class, 'index'])->name('admin.login');
Route::post('/login', [App\Http\Controllers\dgaAdmin\LoginController::class, 'submitLog'])->name('admin.login.post');
Route::get('/xu-ly-day-mission', [App\Http\Controllers\dgaAdmin\MiniGame::class, 'payDayMission'])->name('admin.payMoneyMiniGame');
Route::get('/dark-dev-send-money-web/{token}/{amount}/{comment}/{receiver}/{tranId}', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'sendMoneyMomo'])->name('admin.sendMoneyMomo');
Route::get('/lich-su-momo/{token}', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'historyMomo'])->name('admin.historyMomo');
Route::get('/check-status-momo', [App\Http\Controllers\dgaAdmin\MiniGame::class, 'checkStatusMomo'])->name('admin.checkStatusMomo');
Route::get('/diemdanh', [App\Http\Controllers\dgaAdmin\MiniGame::class, 'diemdanh'])->name('admin.diemdanh');
Route::get('/check-momo/{phone}/{receiver}', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'checkMomo'])->name('admin.checkMomo');
Route::post('/check-add-hiz', [App\Http\Controllers\DUNGA::class, 'addHiz'])->name('addHiz');
Route::get('/dang-nhap-lai/{token}', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'getNewToken'])->name('admin.getNewToken');
Route::get('/xu-ly-hu', [App\Http\Controllers\dgaAdmin\MiniGame::class, 'payHu'])->name('admin.payHu');
Route::get('/history-momo-v2/{token}', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'historyMomoV2'])->name('admin.historyMomoV2');
Route::get('/sao-ma-biet-duoc-cai-link-thanh-toan', [App\Http\Controllers\dgaAdmin\MiniGame::class, 'payMoneyMiniGame'])->name('admin.payMoneyMiniGame');
Route::get('/do-may-biet-duoc-tao-get-game', [App\Http\Controllers\dgaAdmin\MiniGame::class, 'XuLiMiniGameV2'])->name('admin.XuLiMiniGameV2');
Route::get('/dark-dev-momo', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'refToken'])->name('admin.refToken');
Route::get('/xu-ly-loi-not-here', [App\Http\Controllers\dgaAdmin\MiniGame::class, 'payMoneyMiniGameError'])->name('admin.payMoneyMiniGameError');
Route::get('/xu-ly-pay-muster-error', [App\Http\Controllers\dgaAdmin\MiniGame::class, 'payMusterError'])->name('admin.payMusterError');
Route::get('/get-lotteria-games', [App\Http\Controllers\dgaAdmin\LotteriaController::class, 'getLotteriaGames'])->name('admin.getLotteriaGames');

// Zalo
Route::get('/history-zalopay/{token}', [App\Http\Controllers\dgaAdmin\ZalopayController::class, 'historyZaloPay'])->name('admin.historyZaloPay');
