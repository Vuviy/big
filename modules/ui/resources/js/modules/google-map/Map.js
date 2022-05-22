import { mapUtils } from './utils';
import { MAP_LOAD_CSS_CLASS } from './constants';

class Map {
	constructor(element) {
		this.nodeMap = element;
		this.nodeMapDisplay = mapUtils.getDisplayElement(this.nodeMap);
		this.defaultOptions = {
			zoomControl: true,
			mapTypeControl: false,
			scaleControl: false,
			streetViewControl: false,
			rotateControl: false,
			fullscreenControl: false,
			icon: window.app.maps.marker,
			zoom: 13,
			center: {
				// Kiev
				lat: 50.4117979,
				lng: 30.5608369
			}
		};
		this.mapOptions = mapUtils.extendOptions(this.nodeMap, this.defaultOptions);
	}

	createMarkerLabel(text = '', color = 'black') {
		return {
			text,
			color: color,
			fontSize: '14px',
			fontWeight: '400'
		};
	}

	createMarkerIcon(url = '') {
		const { Size } = window.google.maps;
		return {
			url,
			size: new Size(32, 45),
			scaledSize: new Size(32, 45)
		};
	}

	showMap() {
		this.nodeMap.classList.remove(MAP_LOAD_CSS_CLASS);
	}
}

export default Map;
