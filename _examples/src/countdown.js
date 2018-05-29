(function($) {

if (Craft.DiyWidget === undefined) {
    Craft.DiyWidget = {};
}

Craft.DiyWidget.Countdown = Garnish.Base.extend({
    init: function(settings) {
        this.$counter = $('#widget'+settings.widgetId+' .diy-countdown');

        this.$days = this.$counter.find('.days');
        this.$hours = this.$counter.find('.hours');
        this.$minutes = this.$counter.find('.minutes');
        this.$seconds = this.$counter.find('.seconds');

        this.endTime = new Date(Date.now() + (settings.timeRemaining * 1000));
        this.endHtml = settings.endHtml;

        this.initializeClock();
    },

    initializeClock: function() {
        this.$counter.removeClass('hidden');

        this.updateClock();
        this.timer = setInterval(this.updateClock.bind(this), 1000);
    },

    updateClock: function() {
        var t = this.getTimeRemaining(this.endTime);

        if (t.total < 1000) {
            clearInterval(this.timer);
            this.$counter.html(this.endHtml);
        } else {
            this.$days.html(('0'+t.days).slice(-2));
            this.$hours.html(('0'+t.hours).slice(-2));
            this.$minutes.html(('0'+t.minutes).slice(-2));
            this.$seconds.html(('0'+t.seconds).slice(-2));
        }
    },

    getTimeRemaining: function(endDate) {
        var t = endDate.getTime() - Date.now();

        return {
            'total': t,
            'seconds': Math.floor((t / 1000) % 60),
            'minutes': Math.floor((t / 1000 / 60) % 60),
            'hours': Math.floor((t / (1000 * 60 * 60)) % 24),
            'days': Math.floor(t / (1000 * 60 * 60 * 24)),
        };
    },
});

})(jQuery);
