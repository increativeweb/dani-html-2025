export class Popup {
    private popup: HTMLElement;
    private openButtons: HTMLElement[] = [];
    private closeButtons: HTMLElement[] = [];

    constructor(
        popupId: string,
        openSelector?: string,
        closeSelector: string = '[data-role="close-popup"]'
    ) {
        const popup = document.getElementById(popupId);
        if (!popup) throw new Error(`Popup with ID "${popupId}" not found.`);
        this.popup = popup;

        if (openSelector) {
            this.openButtons = Array.from(document.querySelectorAll(openSelector));
        }

        this.closeButtons = Array.from(this.popup.querySelectorAll(closeSelector));

        this.bindEvents();
    }

    private bindEvents(): void {
        this.openButtons.forEach(btn => {
            btn.addEventListener('click', () => this.open());
        });

        this.closeButtons.forEach(btn => {
            btn.addEventListener('click', () => this.close());
        });

        document.addEventListener('keydown', this.handleEscapeKey);
    }

    private handleEscapeKey = (e: KeyboardEvent) => {
        if (e.key === 'Escape') {
            this.close();
        }
    };

    public open(): void {
        this.popup.classList.add('popup-opened');
        document.documentElement.style.overflow = 'hidden'; // <html> overflow:hidden
    }


    public close(): void {
        this.popup.classList.remove('popup-opened');
        document.documentElement.style.overflow = ''; // <html> overflow back to normal
    }

}