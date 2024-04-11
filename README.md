# MikroKontrol - Simple Laravel Web UI for controlling MikroTik devices REST API


![Mikrotik Logo](https://logos-world.net/wp-content/uploads/2023/01/MikroTik-Logo.jpg)


Main template is [Star Admin 2 by BootstrapDash](https://demo.bootstrapdash.com/star-admin2-free/template/index.html) 

Login is based on [Finance Mobile Application-UX/UI Design Screen One login page](https://codepen.io/sowg/pen/qBXjXoE) (slight background changes)

Features:
- View device interfaces (Physical/Virtual/WiFi)
- Bridge configuration
- Security Profile & WiFi configuration
- Address configuration
- Configuration for an assortment of services
    - DHCP
    - DNS
    - Wireguard
    - More if time allows

Modules used:
- [**DataTables**](https://datatables.net/) - Searching, pagination, sorting
- [**SweetAlert**](https://sweetalert2.github.io/) - JS Pop-Up messages
- [**Toastr**](https://www.jqueryscript.net/other/Highly-Customizable-jQuery-Toast-Message-Plugin-Toastr.html) - JQuery Toast messages

Notes:
- The app contains little to no JS (save for a few usability plugins), so it is extremely server-side, expect delays on endpoint communication
- The configuration provided is very simple, if time allows, there will be a custom json text area to allow for a more advanced configuration of the endpoints


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
    - [ ] Wireguard
- Forms (view)
    - [x] Bridges
    - [x] Security Profiles
    - [ ] Wireless Interfaces
    - [x] Addresses
    - [x] Static Routing
    - [ ] DHCP Server
    - [ ] DHCP Client
    - [x] DNS Static Records
    - [x] Wireguard
- PUTs/POSTs (new data)
    - [x] Bridges
    - [ ] Security Profiles
    - [ ] Wireless Interfaces
    - [x] Addresses
    - [ ] Static Routing
    - [ ] DHCP Server
    - [ ] DHCP Client
    - [ ] DNS Server
    - [x] DNS Static Records
    - [x] Wireguard
- PATCHes
    - [ ] Bridges
    - [ ] Security Profiles
    - [ ] Wireless Interfaces
    - [ ] Addresses
    - [ ] Static Routing
    - [ ] DHCP Server
    - [ ] DHCP Client
    - [ ] DNS Server
    - [ ] DNS Static Records
    - [ ] Wireguard
- DELETEs
    - [ ] Bridges
    - [ ] Security Profiles
    - [ ] Wireless Interfaces
    - [ ] Addresses
    - [ ] Static Routing
    - [ ] DHCP Server
    - [ ] DHCP Client
    - [ ] DNS Server
    - [ ] DNS Static Records
    - [ ] Wireguard
- [ ] Error treatment on all pages (check DNS Server (controller/view))
- [ ] Login
- [ ] Device addition and selection (Dashboard)
- [ ] Add wireguard QR code (endpoint needs to be manually inserted)
- [ ] Custom request (JSON textarea on creation/updates)