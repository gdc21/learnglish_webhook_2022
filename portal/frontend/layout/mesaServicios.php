<?php if (!isset($_SESSION['userLogged'])) { ?>
    <script>
        window.fwSettings = {
            'widget_id': <?php echo verificaModuloSistemaRetornoValor("MesaServicios"); ?>
        };
        ! function() {
            if ("function" != typeof window.FreshworksWidget) {
                var n = function() {
                    n.q.push(arguments)
                };
                n.q = [], window.FreshworksWidget = n
            }
        }()
    </script>
    <script type='text/javascript' src='https://widget.freshworks.com/widgets/<?php echo verificaModuloSistemaRetornoValor("MesaServicios"); ?>.js' async defer></script>
<?php } else { ?>
    <script src="https://wchat.freshchat.com/js/widget.js"></script>
    <script>
        (function(d, w, c) {
            if (!d.getElementById("spd-busns-spt")) {
                var n = d.getElementsByTagName('script')[0],
                    s = d.createElement('script');
                var loaded = false;
                s.id = "spd-busns-spt";
                s.async = "async";
                s.setAttribute("data-self-init", "false");
                s.setAttribute("data-init-type", "opt");
                s.src = 'https://cdn.freshbots.ai/assets/share/js/freshbots.min.js';
                s.setAttribute("data-client", "14668a18fc951dd5fb84ee191bf7646e280c8f2b");
                s.setAttribute("data-bot-hash", "c23fc1079a624f88043be455e7e8847155366c81");
                s.setAttribute("data-env", "prod");
                s.setAttribute("data-region", "us");
                if (c) {
                    s.onreadystatechange = s.onload = function() {
                        if (!loaded) {
                            c();
                        }
                        loaded = true;
                    };
                }
                n.parentNode.insertBefore(s, n);
            }
        })(document, window, function() {
            Freshbots.initiateWidget({
                autoInitChat: false,
                getClientParams: function() {
                    return;
                }
            }, function(successResponse) {}, function(errorResponse) {});
        });
    </script>
<?php } ?>