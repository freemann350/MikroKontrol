# MikroKontrol - Simple Laravel Web UI for controlling MikroTik devices REST API

  
  

![Mikrotik Logo](https://logos-world.net/wp-content/uploads/2023/01/MikroTik-Logo.jpg)

  
  

Main template is [Star Admin 2 by BootstrapDash](https://demo.bootstrapdash.com/star-admin2-free/template/index.html)

  

Login is based on [Finance Mobile Application-UX/UI Design Screen One login page](https://codepen.io/sowg/pen/qBXjXoE) (slight background changes)

  

## Features:

- View device interfaces (Physical/Virtual/WiFi)

- Bridge configuration

- Security Profile & WiFi configuration

- Address configuration

- Configuration for an assortment of services

    - DHCP

    - DNS

    - Wireguard

    - More if time allows

  

## Modules used:

- [**DataTables**](https://datatables.net/) - Searching, pagination, sorting

- [**SweetAlert**](https://sweetalert2.github.io/) - JS Pop-Up messages

- [**Toastr**](https://www.jqueryscript.net/other/Highly-Customizable-jQuery-Toast-Message-Plugin-Toastr.html) - JQuery Toast messages

  

## Notes:

- The app contains little to no JS (save for a few usability plugins), so it is extremely server-side, expect delays on endpoint communication

- The configuration provided is very simple, but direct JSON requests can be used on the Creation/Edition endpoints using the `<textarea>` elements on said pages 

  
## Deployment

*It is recommended to use laravel sail if you want to test*
  
After downloading all files (git clone, manual download, ...), run the following commands:

1. Install the Laravel components using
   `composer install`
   
2. Generate the DB using
   `php artisan migrate`
   
3. Seed the DB with default placeholder data
   `php artisan db:seed`

Admin default account: admin@example.com
User default account: user@example.com
All passwords are *password*

## ToDO (by order):

- Individual item info 
    - [ ] Bridges
    - [ ] Security Profiles
    - [ ] Wireless Interfaces
    - [ ] Addresses
    - [ ] Static Routing
    - [ ] DHCP Server
    - [ ] DHCP Client
    - [ ] DNS Server
    - [ ] DNS Static Records
    - [ ] Wireguard Server
    - [ ] Wireguard Client