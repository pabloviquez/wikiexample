Wiki = window.Wiki || {};

/**
 * @description Donations page, JS functionality
 * @author Pablo Viquez <pviquez@pabloviquez.com>
 * @version 1.1
 */
Wiki.Donations = (function() {
    /**
     * Original dollar amounts
     */
    var _dollarAmounts = [];

    /**
     * @private
     * @function _init
     * @description Initialize the object, called when doc is ready
     * @return void
     */
    var _init = function() {
        // Load the currencies from the AJAX endpoint
        loadCurrencies();

        // Lets now store the curencies
        $("#donations > button").each(function (i) {
            _dollarAmounts[i] = $(this).text();
        });

        // Set the event handlers
        $("#currencySelector").change(function() { updateDonationButtons(); });

        // Set the handlers for the buttons
        $("#donations > button").click(function() {
            amount = $(this).text();
            alert("Thank you for your " + amount +  " donation!");
        });
    };

    /**
     * @description Queries the AJAX service and retrieves the data
     * @private
     * @return void
     */
    var loadCurrencies = function () {
        $.get('ajax/currencies.php', function (data) {
            dropdown = $("#currencySelector");

            $.each(data, function(item) {
                dropdown.append($("<option />").val(data[item]).text(data[item]));
            });
        }, "json");
    };

    /**
     * @description Queries the conversion web service and updates the buttons
     *              with the correct amounts to display
     * @private
     * @return void
     */
    var updateDonationButtons = function() {
        // Get the currency selected
        var currency = $("#currencySelector").val();

        if (currency === 'USD') {
            $("#donations > button").each(function (i) {
                $(this).text(_dollarAmounts[i]);
            });

            return;
        }

        // Make the call
        $.get('ajax/conversions.php', { "currency" : currency, "data" : _dollarAmounts.join(":") }, function (data) {
            $("#donations > button").each(function (i) {
                $(this).text(data[i]);
            });
        });
    };

    return {
        /**
         * @description Public alias for _init. Initializes handlers and vars
         * @public
         * @return void
         */
        init : _init
    };
})();

$(Wiki.Donations.init());

