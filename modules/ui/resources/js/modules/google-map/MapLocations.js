import Map from 'js@/modules/google-map/Map';
import { mapUtils } from './utils';
import mapStyles from './styles';
import { getElement } from 'js@/utils/get-element';

class MapLocations extends Map {
	init() {
		const { Map } = window.google.maps;
		this.mapData = mapUtils.getDataJson(this.nodeMap);

		const configurate = Object.assign(this.mapOptions, {
			maxZoom: 16,
			styles: mapStyles
		});

		this.map = new Map(this.nodeMapDisplay, configurate);

		if (Array.isArray(this.mapData) && this.mapData.length) {
			try {
				this.createMarkers();
			} catch (e) {
				console.warn(e);
			}
		}

		this.showMap();
	}

	createMarkers() {
		const { Marker, LatLng, LatLngBounds, Animation, InfoWindow } = window.google.maps;
		// const { markerIcons } = window.app.maps;
		this.markers = [];
		this.clusters = [];
		this.markerGroupsById = {};
		this.infoWindows = [];

		this.bounds = new LatLngBounds();
		this.map.fitBounds(this.bounds, 100);
		for (let i = 0; i < this.mapData.length; i++) {
			const location = this.mapData[i].map;
			const infoWindowTemplate = getElement(this.nodeMap, `[data-info-window="${i}"]`);
			const infoWindowMarkup = infoWindowTemplate.innerHTML;

			if (!location.marker.lat || !location.marker.lng) {
				continue;
			}

			const point = new LatLng(location.marker.lat, location.marker.lng);
			if (location.marker.lat === '0.000000000000000' || location.marker.lng === '0.000000000000000') {
				continue;
			}

			const marker = new Marker({
				id: location.id,
				cityId: location.cityId,
				map: this.map,
				icon: '/images/core/map-pin.png',
				position: point,
				animation: location.active ? Animation.DROP : null
			});


			const infoWindow = new InfoWindow({
				content: infoWindowMarkup
			});

			this.infoWindows.push(infoWindow);

			marker.addListener('click', () => {
				this.infoWindows.forEach((infoWindow) => {
					infoWindow.close();
				});

				infoWindow.open(this.map, marker);
				this.map.panTo(marker.getPosition());
			});

			this.bounds.extend(point);
			this.markers.push(marker);
		}
	}
}

export default MapLocations;
