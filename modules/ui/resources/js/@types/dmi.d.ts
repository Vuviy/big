interface DMIModuleStats {
	moduleName: string;
}

type DMIImportCondition = (elements: HTMLElement[], container: HTMLElement, stats: DMIModuleStats) => boolean;

interface DMIModule {
	filter: string | ((value: HTMLElement, index: number, array: []) => HTMLElement[]);
	importFn(stats: DMIModuleStats): Promise<any>;
	importCondition?: DMIImportCondition;
}

interface DMIOptions {
	selector: string;
	modules: Record<string, DMIModule>;
	debug?: boolean;
	pendingCssClass?: string;
	loadedCssClass?: string;
	errorCssClass?: string;
}

interface DynamicModulesImport {
	readonly debug: boolean;
	readonly selector: string;
	readonly pendingCssClass: string;
	readonly pendingEvent: string;
	readonly loadedCssClass: string;
	readonly loadedEvent: string;
	readonly errorCssClass: string;
	readonly errorEvent: string;
	importModule(moduleName: string, container?: HTMLElement, ignoreImportCondition?: boolean): Promise<any>;
	importAll(container?: HTMLElement, awaitAll?: boolean, ignoreImportCondition?: boolean): Promise<any>;
}
