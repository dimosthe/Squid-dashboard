PXaaS Dashboard
============================

The PXaaS Dashboard enables a user, who acts as the network administrator of his LAN, to configure the Squid Proxy on demand. The configuration parameters are stored in a MySql Database. In order for a new configuration to take effect, the squid.conf and squidGuard.conf files are modified accordingly by the apache process (after a Squid restart is performed by the user).    


REQUIREMENTS
------------

* [Proxy Build configuration](https://github.com/dimosthe/proxy-build) deploys the development environment which eventually deploys the PXaaS Dashboard as well.

Versions
--------

version 1. Features:

* User management: User accounts can be created with a username and password. Those accounts are used to access the proxy services.
* Access control: Users must enter their credentials in their browsers in order to surf the web.
* Bandwidth limitations: Group of users can be created with a shared amount of bandwidth. In this case bandwidth limitations can be introduced to a group of users.
* Website filtering: Group of users can be created with restricted access to a list of websites. Pre-defined lists with urls are provided.
* Web caching: Web caching can be enabled in order to cache web content and improve response time.
* User Anonymity: Users can surf the web anonymously.