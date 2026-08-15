class TerminalApplication {
    constructor(root = document.querySelector('.ait-app')) {
        this.root = root;
        this.bind();
    }

    bind() {
        document.addEventListener('keydown', (event) => {
            if ((event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 'p') {
                event.preventDefault();
                window.print();
            }
        });
    }
}

new TerminalApplication();
