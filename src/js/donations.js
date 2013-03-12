/**
 * Donations page JS functionality
 *
 * @author Pablo Viquez <pviquez@pabloviquez.com>
 */
Wiki = window.Wiki || {};

Wiki.Donations = {
    /**
     * Original dollar amounts
     */
    dollarAmounts : [],

    /**
     * Initialize the object, called when doc is ready
     */
    init : function() {
        //self.loadCurrencies;
        Wiki.Donations.loadCurrencies();

        // Lets now store the curencies
        $("#donations > button").each(function (i) {
            Wiki.Donations.dollarAmounts[i] = $(this).text();
        });

        // Set the event handlers
        $("#currencySelector").change(function() { Wiki.Donations.updateDonationButtons(); });

        // Set the handlers for the buttons
        $("#donations > button").click(function() {
            amount = $(this).text();
            alert("Thank you for your " + amount +  " donation!");
        });
    },

    /**
     * Queries the AJAX service and retrieves the data
     * @return void
     */
    loadCurrencies : function () {
        $.get('ajax/currencies.php', function (data) {
            dropdown = $("#currencySelector");

            $.each(data, function(item) {
                dropdown.append($("<option />").val(data[item]).text(data[item]));
            });
        }, "json");
    },

    /**
     * Queries the conversion web service and updates the buttons with the
     * correct amounts to display
     * @return void
     */
    updateDonationButtons : function() {
        // Get the currency selected
        var currency = $("#currencySelector").val();

        if (currency === 'USD') {
            $("#donations > button").each(function (i) {
                $(this).text(Wiki.Donations.dollarAmounts[i]);
            });

            return;
        }

        // Make the call
        $.get('ajax/conversions.php', { "currency" : currency, "data" : Wiki.Donations.dollarAmounts.join(":") }, function (data) {
            $("#donations > button").each(function (i) {
                $(this).text(data[i]);
            });
        });
    }
};

$(Wiki.Donations.init);

