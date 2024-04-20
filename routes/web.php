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
    Route::post('/DHCPServers/New','storeDhcpServer')->name("storeDhcpServer");
    Route::get('/DHCPServers/Edit/{DHCPServer}','editDhcpServer')->name("editDhcpServer");
    Route::put('/DHCPServers/Edit/{DHCPServer}','updateDhcpServer')->name("updateDhcpServer");
    Route::delete('/DHCPServers/{DHCPServer}','destroyDhcpServer')->name("destroyDhcpServer");
    ////
    Route::get('/DHCPClients','client')->name("dhcp_client");
    Route::get('/DHCPClients/New','createDhcpClient')->name("createDhcpClient");
    Route::post('/DHCPClients/New','storeDhcpClient')->name("storeDhcpClient");
    Route::get('/DHCPClients/Edit/{DHCPClient}','editDhcpClient')->name("editDhcpClient");
    Route::put('/DHCPClients/Edit/{DHCPClient}','updateDhcpClient')->name("updateDhcpClient");
    Route::delete('/DHCPClients/{DHCPClient}','destroyDhcpClient')->name("destroyDhcpClient");
});

Route::controller(DnsController::class)->group(function () {
    Route::get('/DNSServer','server')->name("dns_server");
    Route::get('/DNSServer/Edit','editDnsServer')->name("editDnsServer");
    Route::post('/DNSServer/Edit','storeDnsServer')->name("storeDnsServer");
    ////
    Route::get('/DNSStaticRecords','records')->name("dns_records");
    Route::get('/DNSStaticRecords/New','createDnsRecord')->name("createDnsRecord");
    Route::post('/DNSStaticRecords/New/store','storeDnsRecord')->name("storeDnsRecord");
    Route::get('/DNSStaticRecords/Edit/{DNSStaticRecord}','editDnsRecord')->name("editDnsRecord");
    Route::put('/DNSStaticRecords/Edit/{DNSStaticRecord}','updateDnsRecord')->name("updateDnsRecord");
    Route::delete('/DNSStaticRecords/{DNSStaticRecord}','destroyDnsRecord')->name("destroyDnsRecord");
});

Route::controller(WireguardController::class)->group(function () {
    Route::get('/WireguardServers','servers')->name('wireguard_servers');
    Route::get('/WireguardServers/New','createServer')->name('wireguard_createServer');
    Route::post('/WireguardServers/New','storeServer')->name('wireguard_storeServer');
    Route::get('/WireguardServers/Edit/{Server}','editServer')->name('wireguard_editServer');
    Route::put('/WireguardServers/Edit/{Server}','updateServer')->name('wireguard_updateServer');
    Route::delete('/WireguardServers/{Server}','destroyServer')->name('wireguard_destroyServer');
    ////
    Route::get('/WireguardPeers','clients')->name('wireguard_clients');
    Route::get('/WireguardPeers/New','createClient')->name('wireguard_createClient');
    Route::post('/WireguardPeers/New','storeClient')->name('wireguard_storeClient');
    Route::get('/WireguardPeers/Edit/{Client}','editClient')->name('wireguard_editClient');
    Route::put('/WireguardPeers/Edit/{Client}','updateClient')->name('wireguard_updateClient');
    Route::delete('/WireguardPeers/{Client}','destroyClient')->name('wireguard_destroyClient');
});