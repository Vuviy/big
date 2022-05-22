declare interface Livewire {
	first(): any;
	find(componentId: string): any;
	all(): any;
	directive(name: string, callback: (...args: any[]) => void): void;
	hook(name: string, callback: (...args: any[]) => void): void;
	onLoad(callback: (...args: any[]) => void): void;
	onError(callback: (...args: any[]) => void): void;
	emit(event: string, ...params: any[]): void;
	emitTo(name: string, event: string, ...params: any[]): void;
	on(event: string, callback: (...args: any[]) => void): void;
	devTools(enableDevtools: boolean): void;
	restart(): void;
	stop(): void;
	start(): void;
	rescan(node: Node | Element | null): void;
}
