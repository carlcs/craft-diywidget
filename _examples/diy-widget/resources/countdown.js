Craft.DiyWidget = Craft.DiyWidget || {};

Craft.DiyWidget.Countdown = class {
    constructor(settings) {
        this.countdown = document.querySelector(`#widget${settings.widgetId} .diy-countdown`);
        this.days = this.countdown.querySelector('.days');
        this.hours = this.countdown.querySelector('.hours');
        this.minutes = this.countdown.querySelector('.minutes');
        this.seconds = this.countdown.querySelector('.seconds');

        this.endTime = new Date(Date.now() + settings.timeRemaining * 1000);
        this.endHtml = settings.endHtml;

        this.updateCountdown();
        this.timer = setInterval(this.updateCountdown.bind(this), 1000);
    }

    updateCountdown() {
        const time = this.getTimeRemaining(this.endTime);
        const isOver = Object.values(time).every((value) => value === 0);

        if (isOver) {
            this.countdown.innerHTML = this.endHtml;
            clearInterval(this.timer);
        } else {
            Object.keys(time).forEach((name) => {
                const el = this[name];
                const value = ('0' + time[name]).slice(-2);
                el.querySelector('.diy-countdown__value').innerHTML = value;

                if (
                    (name == 'days' && time.days === 0) ||
                    (name == 'seconds' && time.days !== 0)
                ) {
                    el.classList.add('hidden');
                } else {
                    el.classList.remove('hidden');
                }
            });
        }
    }

    getTimeRemaining(endDate) {
        const t = endDate.getTime() - Date.now();
        return {
            seconds: Math.floor((t / 1000) % 60),
            minutes: Math.floor((t / 1000 / 60) % 60),
            hours: Math.floor((t / (1000 * 60 * 60)) % 24),
            days: Math.floor(t / (1000 * 60 * 60 * 24)),
        };
    }
};
