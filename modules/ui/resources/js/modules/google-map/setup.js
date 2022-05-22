import MapLocations from 'js@/modules/google-map/MapLocations';
import MapDefault from 'js@/modules/google-map/MapDefault';

function googleMapSetup(map) {
	let googleMap = null;

	switch (map.dataset.gmap) {
		case 'locations':
			googleMap = new MapLocations(map);
			googleMap.init();
			break;
		default:
			googleMap = new MapDefault(map);
			googleMap.init();
	}
}

export { googleMapSetup };
