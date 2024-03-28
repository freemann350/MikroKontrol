<?php

use App\Http\Controllers\BridgeController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DhcpController;
use App\Http\Controllers\DnsController;
use App\Http\Controllers\InterfacesController;
use App\Http\Controllers\IpAddressController;
use App\Http\Controllers\SecurityProfileController;
use App\Http\Controllers\StaticRouteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WireguardController;
use App\Http\Controllers\WirelessController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

Route::controller(UserController::class)->group(function () {

});

Route::controller(DeviceController::class)->group(function () {

});

Route::controller(InterfacesController::class)->group(function () {
    Route::resource('/Interfaces',InterfacesController::class);
});

Route::controller(BridgeController::class)->group(function () {
    Route::resource('/Bridges',BridgeController::class);
});

Route::controller(SecurityProfileController::class)->group(function () {
    Route::resource('/SecurityProfiles',SecurityProfileController::class);
});

Route::controller(WirelessController::class)->group(function () {
    Route::resource('/Wireless',WirelessController::class);
});

Route::controller(IpAddressController::class)->group(function () {
    Route::resource('/IPAddresses',IpAddressController::class);
});

Route::controller(StaticRouteController::class)->group(function () {
    Route::resource('/StaticRoutes',StaticRouteController::class);
});

Route::controller(DhcpController::class)->group(function () {
    Route::get('/DHCPServers','servers')->name("dhcp_servers");
    Route::get('/DHCPServers/New','createDhcpServer')->name("createDhcpServer");
    Route::get('/DHCPClients','client')->name("dhcp_client");
    Route::get('/DHCPClients/New','createDhcpClient')->name("createDhcpClient");
    Route::resource('/DHCP',DhcpController::class);
});

Route::controller(DnsController::class)->group(function () {
    Route::get('/DNSServer','server')->name("dns_server");
    Route::get('/DNSServer/New','editDnsServer')->name("editDnsServer");
    Route::get('/DNSStaticRecords','records')->name("dns_records");
    Route::get('/DNSStaticRecords/New','createDnsRecord')->name("createDnsRecord");
});

Route::controller(WireguardController::class)->group(function () {
    Route::resource('/Wireguard',WireguardController::class);
});