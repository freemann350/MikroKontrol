![Mikrotik Logo](https://logos-world.net/wp-content/uploads/2023/01/MikroTik-Logo.jpg)

Simple Laravel Web UI for controlling MikroTik devices REST API

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

Notes:
- The app contains little to no JS, so it is extremely server-side, expect delays on endpoint communication
- The configuration provided is very simple, if time allows, there will be a custom json box to allow a more advanced configuration of the endpoints