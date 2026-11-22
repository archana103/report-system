    <!-- Christmas Offer Popup -->
    <div id="christmas-offer-overlay" style="
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.65);
        z-index: 99999;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        opacity: 0;
        transition: opacity 0.35s ease;
    ">
        <div style="
            position: relative;
            max-width: 520px;
            width: 90%;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5);
            transform: scale(0.9);
            transition: transform 0.35s ease;
        " id="christmas-offer-card">
            <!-- Close Button -->
            <button
                id="christmas-close-btn"
                onclick="closeChristmasPopup()"
                aria-label="Close offer"
                style="
                    position: absolute;
                    top: 10px;
                    right: 10px;
                    width: 36px;
                    height: 36px;
                    border-radius: 50%;
                    border: none;
                    background: rgba(255,255,255,0.9);
                    color: #333;
                    font-size: 20px;
                    font-weight: 700;
                    line-height: 1;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 10;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.25);
                    transition: background 0.2s, transform 0.2s;
                "
                onmouseover="this.style.background='#fff'; this.style.transform='scale(1.1)'"
                onmouseout="this.style.background='rgba(255,255,255,0.9)'; this.style.transform='scale(1)'"
            >&times;</button>

            <!-- Offer Image -->
            <img
                src="https://epignosisinsights-images.s3.ap-south-1.amazonaws.com/chrimas_offer/chrimas_offer_20per.webp"
                alt="Christmas Special Offer - 20% Off"
                style="width: 100%; display: block;"
                loading="eager"
            />
        </div>
    </div>

    <script>
        (function () {

            function openChristmasPopup() {
                var overlay = document.getElementById('christmas-offer-overlay');
                var card    = document.getElementById('christmas-offer-card');
                if (!overlay) return;

                overlay.style.display = 'flex';
                // Trigger transition after paint
                requestAnimationFrame(function () {
                    requestAnimationFrame(function () {
                        overlay.style.opacity = '1';
                        card.style.transform  = 'scale(1)';
                    });
                });
            }

            window.closeChristmasPopup = function () {
                var overlay = document.getElementById('christmas-offer-overlay');
                var card    = document.getElementById('christmas-offer-card');
                if (!overlay) return;

                overlay.style.opacity = '0';
                card.style.transform  = 'scale(0.9)';
                setTimeout(function () {
                    overlay.style.display = 'none';
                }, 350);
            };

            // Close on backdrop click
            document.getElementById('christmas-offer-overlay').addEventListener('click', function (e) {
                if (e.target === this) window.closeChristmasPopup();
            });

            // Show only once per browser; hidden on all later visits/refreshes
            var POPUP_KEY = 'christmas_offer_shown';
            var alreadyShown = false;
            try { alreadyShown = localStorage.getItem(POPUP_KEY) === '1'; } catch (e) {}

            if (!alreadyShown) {
                try { localStorage.setItem(POPUP_KEY, '1'); } catch (e) {}
                setTimeout(openChristmasPopup, 600);
            }
        })();
    </script>
