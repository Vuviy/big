import Map from 'js@/modules/google-map/Map';

class MapDefault extends Map {
	init() {
		const { Map } = window.google.maps;

		this.map = new Map(this.nodeMapDisplay, this.mapOptions);
		this.markers = [];

		if (this.mapOptions.icon) {
			try {
				this.createMarkers();
			} catch (e) {
				console.warn(e);
			}
		}

		this.showMap();
	}

	createMarkers() {
		const { Marker, LatLng } = window.google.maps;
		const { icon, markers } = this.mapOptions;
		const bounds = new window.google.maps.LatLngBounds();

		for (let i = 0; i < markers.length; i++) {
			this.markers.push(
				new Marker({
					map: this.map,
					icon: icon,
					position: new LatLng(markers[i].lat, markers[i].lng),
					clickable: false
				})
			);
			bounds.extend(this.markers[i].getPosition());
		}

		this.map.fitBounds(bounds, 30);
	}
}

export default MapDefault;
