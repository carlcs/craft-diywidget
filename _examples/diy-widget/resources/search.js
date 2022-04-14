Craft.DiyWidget = Craft.DiyWidget || {};

Craft.DiyWidget.Search = class {
    constructor(settings) {
        this.templatePath = settings.templatePath;
        this.widget = document.querySelector(`#widget${settings.widgetId} .diy-search`);
        this.search = this.widget.querySelector('.search input');
        this.clearBtn = this.widget.querySelector('.search .clear');
        this.spinner = this.widget.querySelector('.spinner');
        this.results = this.widget.querySelector('.diy-search__results');

        this.search.addEventListener('input', debounce(this.updateResults.bind(this), 500));
        this.search.addEventListener('input', () => {
            if (this.search.value) {
                this.clearBtn.classList.remove('hidden');
            } else {
                this.clearBtn.classList.add('hidden');
            }
        });

        this.clearBtn.addEventListener('click', () => {
            this.search.value = '';
            this.clearBtn.classList.add('hidden');
            this.updateResults();
        });
    }

    updateResults() {
        this.spinner.classList.remove('hidden');
        this.results.innerHTML = '';

        const data = {
            query: this.search.value,
            templatePath: this.templatePath,
        };

        Craft.sendActionRequest('POST', 'diy-widget/diy-widget/get-html', { data }).then(({ data }) => {
            this.spinner.classList.add('hidden');
            this.results.innerHTML = data.html;
        });
    }
};

function debounce(callback, wait) {
    let timeoutId = null;
    return (...args) => {
        window.clearTimeout(timeoutId);
        timeoutId = window.setTimeout(() => {
            callback.apply(null, args);
        }, wait);
    };
}

