package com.teamX.projetx.utils;

import android.location.LocationManager;

/**
 * Created by Paul on 09/07/2017.
 */

public class Localization {
    private LocationManager locationManager;

    public Localization(LocationManager locationManager) {
        this.locationManager = locationManager;
        this.updateGPSPosition();
    }

    /**
     * Provide GPS Position (Permission error)
     * @return
     */
    private String updateGPSPosition() {
        // Or, use GPS location data:
        String locationProvider = LocationManager.GPS_PROVIDER;

        // locationManager.requestLocationUpdates(locationProvider, 0, 0, locationListener);
        return locationProvider;
    }
}
