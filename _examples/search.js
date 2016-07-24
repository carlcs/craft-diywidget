(function($) {

if (Craft.DiyWidget === undefined) {
  Craft.DiyWidget = {};
}

Craft.DiyWidget.Search = Garnish.Base.extend(
{
  settings: null,

  searching: false,
  searchTimeout: null,

  $widget: null,
  $search: null,
  $clearSearchBtn: null,
  $results: null,

  init: function(settings)
  {
    this.setSettings(settings);

    this.$widget = $('#'+settings.widgetId);
    this.$search = this.$widget.find('.search input');
    this.$clearSearchBtn = this.$widget.find('.search .clear');
    this.$results = this.$widget.find('.search-results');

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

  updateSearchResults: function()
  {
    var data = {
      query: this.$search.val(),
      templatePath: this.settings.templatePath,
    };

    Craft.postActionRequest('diyWidget/getHtml', data, $.proxy(function(response, textStatus) {
      if (textStatus == 'success') {
        this.$results.html(response.html);
      } else {
        console.log('error');
      }
    }, this));
  },
});

})(jQuery);
