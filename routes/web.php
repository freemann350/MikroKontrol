<?php

use App\Http\Controllers\AuthController;
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
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DeviceControlMiddleware;
use App\Http\Middleware\EditUserMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/','index')->name("login");
    Route::post('/Login','login')->name("Auth.login");
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::controller(AuthController::class)->group(function () {
        Route::get('/Logout','logout')->name("Auth.logout");
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/Users','index')->name("users_all")->middleware(AdminMiddleware::class);
        Route::get('/User/{User}/edit','edit')->name("User.edit")->middleware(EditUserMiddleware::class);
        Route::put('/User/{User}','update')->name("User.update")->middleware(EditUserMiddleware::class);
        Route::resource('/User',UserController::class)->except(['index','edit','update'])->middleware(AdminMiddleware::class);
    });

    Route::controller(DeviceController::class)->group(function () {
        Route::resource('/Devices',DeviceController::class)->except('index')->middleware(DeviceControlMiddleware::class);
        Route::get('/{Device}/Overview/','indexDevice')->name("Device.index")->middleware(DeviceControlMiddleware::class);
        Route::get('/Dashboard','index')->name("Dashboard.index");

    });

    Route::middleware(DeviceControlMiddleware::class)->group(function() {
        Route::controller(InterfacesController::class)->group(function () {
            Route::resource('/{Device}/Interfaces',InterfacesController::class);
        });

        Route::controller(BridgeController::class)->group(function () {
            Route::resource('/{Device}/Bridges',BridgeController::class);
            Route::post('/{Device}/Bridges/NewCustom','storeCustom')->name("bridge_storeCustom");
            Route::put('/{Device}/Bridges/{id}/EditCustom','updateCustom')->name("bridge_updateCustom");
        });

        Route::controller(SecurityProfileController::class)->group(function () {
            Route::resource('/{Device}/SecurityProfiles',SecurityProfileController::class);
            Route::post('/{Device}/SecurityProfiles/NewCustom','storeCustom')->name("sp_storeCustom");
            Route::put('/{Device}/SecurityProfiles/{id}/EditCustom','updateCustom')->name("sp_updateCustom");
        });

        Route::controller(WirelessController::class)->group(function () {
            Route::resource('/{Device}/Wireless',WirelessController::class);
            Route::post('/{Device}/Wireless/NewCustom','storeCustom')->name("wireless_storeCustom");
            Route::put('/{Device}/Wireless/{id}/EditCustom','updateCustom')->name("wireless_updateCustom");
        });

        Route::controller(IpAddressController::class)->group(function () {
            Route::resource('/{Device}/IPAddresses',IpAddressController::class);
            Route::post('/{Device}/IPAddresses/NewCustom','storeCustom')->name("address_storeCustom");
            Route::put('/{Device}/IPAddresses/{id}/EditCustom','updateCustom')->name("address_updateCustom");
        });

        Route::controller(StaticRouteController::class)->group(function () {
            Route::resource('/{Device}/StaticRoutes',StaticRouteController::class);
            Route::post('/{Device}/StaticRoutes/NewCustom','storeCustom')->name("sr_storeCustom");
            Route::put('/{Device}/StaticRoutes/{id}/EditCustom','updateCustom')->name("sr_updateCustom");
        });

        Route::controller(DhcpController::class)->group(function () {
            Route::get('/{Device}/DHCPServers','servers')->name("dhcp_servers");
            Route::get('/{Device}/DHCPServers/New','createDhcpServer')->name("createDhcpServer");
            Route::post('/{Device}/DHCPServers/New','storeDhcpServer')->name("storeDhcpServer");
            Route::post('/{Device}/DHCPServers/NewCustom','storeServerCustom')->name("dhcp_storeServerCustom");
            Route::get('/{Device}/DHCPServers/edit/{DHCPServer}','editDhcpServer')->name("editDhcpServer");
            Route::put('/{Device}/DHCPServers/edit/{DHCPServer}','updateDhcpServer')->name("updateDhcpServer");
            Route::put('/{Device}/DHCPServers/{id}/EditCustom','updateServerCustom')->name("dhcp_updateServerCustom");
            Route::delete('/{Device}/DHCPServers/{DHCPServer}','destroyDhcpServer')->name("destroyDhcpServer");
            ////
            Route::get('/{Device}/DHCPClients','client')->name("dhcp_client");
            Route::get('/{Device}/DHCPClients/New','createDhcpClient')->name("createDhcpClient");
            Route::post('/{Device}/DHCPClients/New','storeDhcpClient')->name("storeDhcpClient");
            Route::post('/{Device}/DHCPClients/NewCustom','storeClientCustom')->name("dhcp_storeClientCustom");
            Route::get('/{Device}/DHCPClients/edit/{DHCPClient}','editDhcpClient')->name("editDhcpClient");
            Route::put('/{Device}/DHCPClients/edit/{DHCPClient}','updateDhcpClient')->name("updateDhcpClient");
            Route::put('/{Device}/DHCPClients/{id}/EditCustom','updateClientCustom')->name("dhcp_updateClientCustom");
            Route::delete('/{Device}/DHCPClients/{DHCPClient}','destroyDhcpClient')->name("destroyDhcpClient");
        });

        Route::controller(DnsController::class)->group(function () {
            Route::get('/{Device}/DNSServer','server')->name("dns_server");
            Route::get('/{Device}/DNSServer/edit','editDnsServer')->name("editDnsServer");
            Route::post('/{Device}/DNSServer/edit','storeDnsServer')->name("storeDnsServer");
            Route::post('/{Device}/DNSServer/EditCustom','storeServerCustom')->name("dns_storeServerCustom");
            ////
            Route::get('/{Device}/DNSStaticRecords','records')->name("dns_records");
            Route::get('/{Device}/DNSStaticRecords/New','createDnsRecord')->name("createDnsRecord");
            Route::post('/{Device}/DNSStaticRecords/New','storeDnsRecord')->name("storeDnsRecord");
            Route::post('/{Device}/DNSStaticRecords/NewCustom','storeRecordCustom')->name("dns_storeRecordCustom");
            Route::get('/{Device}/DNSStaticRecords/edit/{DNSStaticRecord}','editDnsRecord')->name("editDnsRecord");
            Route::put('/{Device}/DNSStaticRecords/edit/{DNSStaticRecord}','updateDnsRecord')->name("updateDnsRecord");
            Route::put('/{Device}/DNSStaticRecords/EditCustom/{id}','updateRecordCustom')->name("dns_updateRecordCustom");
            Route::delete('/{Device}/DNSStaticRecords/{DNSStaticRecord}','destroyDnsRecord')->name("destroyDnsRecord");
        });

        Route::controller(WireguardController::class)->group(function () {
            Route::get('/{Device}/WireguardServers','servers')->name('wireguard_servers');
            Route::get('/{Device}/WireguardServers/New','createServer')->name('wireguard_createServer');
            Route::post('/{Device}/WireguardServers/New','storeServer')->name('wireguard_storeServer');
            Route::post('/{Device}/WireguardServers/NewCustom','storeServerCustom')->name("wg_storeServerCustom");
            Route::get('/{Device}/WireguardServers/edit/{Server}','editServer')->name('wireguard_editServer');
            Route::put('/{Device}/WireguardServers/edit/{Server}','updateServer')->name('wireguard_updateServer');
            Route::put('/{Device}/WireguardServers/EditCustom/{id}','updateServerCustom')->name("wg_updateServerCustom");
            Route::delete('/{Device}/WireguardServers/{Server}','destroyServer')->name('wireguard_destroyServer');
            ////
            Route::get('/{Device}/WireguardPeers','clients')->name('wireguard_clients');
            Route::get('/{Device}/WireguardPeers/New','createClient')->name('wireguard_createClient');
            Route::post('/{Device}/WireguardPeers/New','storeClient')->name('wireguard_storeClient');
            Route::post('/{Device}/WireguardPeers/NewCustom','storeClientCustom')->name("wg_storeClientCustom");
            Route::get('/{Device}/WireguardPeers/edit/{Client}','editClient')->name('wireguard_editClient');
            Route::put('/{Device}/WireguardPeers/edit/{Client}','updateClient')->name('wireguard_updateClient');
            Route::put('/{Device}/WireguardPeers/EditCustom/{id}','updateClientCustom')->name("wg_updateClientCustom");
            Route::delete('/{Device}/WireguardPeers/{Client}','destroyClient')->name('wireguard_destroyClient');
        });
    });
});
