(function($) {

if (Craft.DiyWidget === undefined) {
    Craft.DiyWidget = {};
}

Craft.DiyWidget.Search = Garnish.Base.extend({
    settings: null,

    searching: false,
    searchTimeout: null,

    $widget: null,
    $search: null,
    $clearSearchBtn: null,
    $spinner: null,
    $results: null,

    init: function(settings) {
        this.setSettings(settings);

        this.$widget = $('#widget'+settings.widgetId);
        this.$search = this.$widget.find('.search input');
        this.$clearSearchBtn = this.$widget.find('.search .clear');
        this.$spinner = this.$widget.find('.spinner');
        this.$results = this.$widget.find('.diy-search__results');

        // Automatically update the elements after new search text has been sitting for a 1/2 second
        this.$search.on('textchange', $.proxy(function(ev) {
            ev.preventDefault();

            if (!this.searching && this.$search.val()) {
                this.$clearSearchBtn.removeClass('hidden');
                this.searching = true;
            } else if (this.searching && !this.$search.val()) {
                this.$clearSearchBtn.addClass('hidden');
                this.searching = false;
            }

            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }

            this.searchTimeout = setTimeout($.proxy(this, 'updateSearchResults'), 500);
        }, this));

        // Update the elements when the Return key is pressed
        this.$search.on('keypress', $.proxy(function(ev) {
            if (ev.keyCode == Garnish.RETURN_KEY) {
                ev.preventDefault();

                if (this.searchTimeout) {
                    clearTimeout(this.searchTimeout);
                }

                this.updateSearchResults();
            }
        }, this));

        // Clear the search when the X button is clicked
        this.addListener(this.$clearSearchBtn, 'click', $.proxy(function() {
            this.$search.val('');

            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }

            this.$clearSearchBtn.addClass('hidden');
            this.searching = false;

            this.updateSearchResults();
        }, this))
    },

    updateSearchResults: function() {
        this.$spinner.removeClass('hidden');

        var data = {
            query: this.$search.val(),
            templatePath: this.settings.templatePath,
        };

        Craft.postActionRequest('diy-widget/diy-widget/get-html', data, $.proxy(function(response, textStatus) {
            this.$spinner.addClass('hidden');

            if (textStatus == 'success') {
                this.$results.html(response.html);
            }
        }, this));
    },
});

})(jQuery);
