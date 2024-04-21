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
    Route::post('/Bridges/NewCustom','storeCustom')->name("bridge_storeCustom");
    Route::put('/Bridges/{id}/EditCustom','updateCustom')->name("bridge_updateCustom");
});

Route::controller(SecurityProfileController::class)->group(function () {
    Route::resource('/SecurityProfiles',SecurityProfileController::class);
    Route::post('/SecurityProfiles/NewCustom','storeCustom')->name("sp_storeCustom");
    Route::put('/SecurityProfiles/{id}/EditCustom','updateCustom')->name("sp_updateCustom");
});

Route::controller(WirelessController::class)->group(function () {
    Route::resource('/Wireless',WirelessController::class);
    Route::post('/Wireless/NewCustom','storeCustom')->name("wireless_storeCustom");
    Route::put('/Wireless/{id}/EditCustom','updateCustom')->name("wireless_updateCustom");
});

Route::controller(IpAddressController::class)->group(function () {
    Route::resource('/IPAddresses',IpAddressController::class);
    Route::post('/IPAddresses/NewCustom','storeCustom')->name("address_storeCustom");
    Route::put('/IPAddresses/{id}/EditCustom','updateCustom')->name("address_updateCustom");
});

Route::controller(StaticRouteController::class)->group(function () {
    Route::resource('/StaticRoutes',StaticRouteController::class);
    Route::post('/StaticRoutes/NewCustom','storeCustom')->name("sr_storeCustom");
    Route::put('/StaticRoutes/{id}/EditCustom','updateCustom')->name("sr_updateCustom");
});

Route::controller(DhcpController::class)->group(function () {
    Route::get('/DHCPServers','servers')->name("dhcp_servers");
    Route::get('/DHCPServers/New','createDhcpServer')->name("createDhcpServer");
    Route::post('/DHCPServers/New','storeDhcpServer')->name("storeDhcpServer");
    Route::post('/DHCPServers/NewCustom','storeServerCustom')->name("dhcp_storeServerCustom");
    Route::get('/DHCPServers/edit/{DHCPServer}','editDhcpServer')->name("editDhcpServer");
    Route::put('/DHCPServers/edit/{DHCPServer}','updateDhcpServer')->name("updateDhcpServer");
    Route::put('/DHCPServers/{id}/EditCustom','updateServerCustom')->name("dhcp_updateServerCustom");
    Route::delete('/DHCPServers/{DHCPServer}','destroyDhcpServer')->name("destroyDhcpServer");
    ////
    Route::get('/DHCPClients','client')->name("dhcp_client");
    Route::get('/DHCPClients/New','createDhcpClient')->name("createDhcpClient");
    Route::post('/DHCPClients/New','storeDhcpClient')->name("storeDhcpClient");
    Route::post('/DHCPClients/NewCustom','storeClientCustom')->name("dhcp_storeClientCustom");
    Route::get('/DHCPClients/edit/{DHCPClient}','editDhcpClient')->name("editDhcpClient");
    Route::put('/DHCPClients/edit/{DHCPClient}','updateDhcpClient')->name("updateDhcpClient");
    Route::put('/DHCPClients/{id}/EditCustom','updateClientCustom')->name("dhcp_updateClientCustom");
    Route::delete('/DHCPClients/{DHCPClient}','destroyDhcpClient')->name("destroyDhcpClient");
});

Route::controller(DnsController::class)->group(function () {
    Route::get('/DNSServer','server')->name("dns_server");
    Route::get('/DNSServer/edit','editDnsServer')->name("editDnsServer");
    Route::post('/DNSServer/edit','storeDnsServer')->name("storeDnsServer");
    Route::post('/DNSServer/EditCustom','storeServerCustom')->name("dns_storeServerCustom");
    ////
    Route::get('/DNSStaticRecords','records')->name("dns_records");
    Route::get('/DNSStaticRecords/New','createDnsRecord')->name("createDnsRecord");
    Route::post('/DNSStaticRecords/New','storeDnsRecord')->name("storeDnsRecord");
    Route::post('/DNSStaticRecords/NewCustom','storeRecordCustom')->name("dns_storeRecordCustom");
    Route::get('/DNSStaticRecords/edit/{DNSStaticRecord}','editDnsRecord')->name("editDnsRecord");
    Route::put('/DNSStaticRecords/edit/{DNSStaticRecord}','updateDnsRecord')->name("updateDnsRecord");
    Route::put('/DNSStaticRecords/EditCustom/{id}','updateRecordCustom')->name("dns_updateRecordCustom");
    Route::delete('/DNSStaticRecords/{DNSStaticRecord}','destroyDnsRecord')->name("destroyDnsRecord");
});

Route::controller(WireguardController::class)->group(function () {
    Route::get('/WireguardServers','servers')->name('wireguard_servers');
    Route::get('/WireguardServers/New','createServer')->name('wireguard_createServer');
    Route::post('/WireguardServers/New','storeServer')->name('wireguard_storeServer');
    Route::post('/WireguardServers/NewCustom','storeServerCustom')->name("wg_storeServerCustom");
    Route::get('/WireguardServers/edit/{Server}','editServer')->name('wireguard_editServer');
    Route::put('/WireguardServers/edit/{Server}','updateServer')->name('wireguard_updateServer');
    Route::put('/WireguardServers/EditCustom/{id}','updateServerCustom')->name("wg_updateServerCustom");
    Route::delete('/WireguardServers/{Server}','destroyServer')->name('wireguard_destroyServer');
    ////
    Route::get('/WireguardPeers','clients')->name('wireguard_clients');
    Route::get('/WireguardPeers/New','createClient')->name('wireguard_createClient');
    Route::post('/WireguardPeers/New','storeClient')->name('wireguard_storeClient');
    Route::post('/WireguardPeers/NewCustom','storeClientCustom')->name("wg_storeClientCustom");
    Route::get('/WireguardPeers/edit/{Client}','editClient')->name('wireguard_editClient');
    Route::put('/WireguardPeers/edit/{Client}','updateClient')->name('wireguard_updateClient');
    Route::put('/WireguardPeers/EditCustom/{id}','updateClientCustom')->name("wg_updateClientCustom");
    Route::delete('/WireguardPeers/{Client}','destroyClient')->name('wireguard_destroyClient');
    Route::get('/testing','qrcode');


});