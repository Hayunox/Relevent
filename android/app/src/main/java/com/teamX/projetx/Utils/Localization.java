package com.teamX.projetx.Utils;

import android.Manifest;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.support.v4.app.ActivityCompat;

/**
 * Created by Paul on 09/07/2017.
 */

public class Localization {
    private LocationManager locationManager;
    private LocationListener locationListener;

    public Localization(LocationManager locationManager) {
        this.locationManager = locationManager;
    }

    private void update() {

        // Acquire a reference to the system Location Manager


        // Define a listener that responds to location updates
        this.locationListener = new LocationListener() {
            public void onLocationChanged(Location location) {
                // Called when a new location is found by the network location provider.
                makeUseOfNewLocation(location);
            }

            private void makeUseOfNewLocation(Location location) {
            }

            @Override
            public void onStatusChanged(String provider, int status, Bundle extras) {

            }

            public void onProviderEnabled(String provider) {
            }

            public void onProviderDisabled(String provider) {
            }
        };
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
