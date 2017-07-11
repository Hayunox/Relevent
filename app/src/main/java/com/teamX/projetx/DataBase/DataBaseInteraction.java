package com.teamX.projetx.DataBase;

import android.preference.PreferenceActivity;

import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.JsonHttpResponseHandler;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import cz.msebera.android.httpclient.Header;

/**
 * Created by Paul on 09/07/2017.
 */

public class DataBaseInteraction {

    public DataBaseInteraction(){

    }

    public void userRegister(){
        AsyncHttpClient client = new AsyncHttpClient();
        client.get("192.168.2.77/projetX/index.php/register", new AsyncHttpResponseHandler() {

            @Override
            public void onStart() {
                // called before request is started
            }

            @Override
            public void onSuccess(int statusCode, Header[] headers, byte[] responseBody) {
                System.out.println(responseBody);
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, byte[] responseBody, Throwable error) {
                error.printStackTrace();
            }

            @Override
            public void onRetry(int retryNo) {
                // called when request is retried
            }
        });
        /*DataBaseRestClient.post("register", null, new JsonHttpResponseHandler() {
            @Override
            public void onFailed(int statusCode, PreferenceActivity.Header[] headers, JSONObject response) {
                // If the response is JSONObject instead of expected JSONArray
            }

            @Override
            public void onSuccess(int statusCode, PreferenceActivity.Header[] headers, JSONArray timeline) {
                // Pull out the first event on the public timeline
                JSONObject firstEvent   = null;
                String registerResponse = null;
                try {
                    firstEvent = (JSONObject) timeline.get(0);
                    registerResponse = firstEvent.getString("text");
                } catch (JSONException e) {
                    e.printStackTrace();
                }

                // Do something with the response
                System.out.println(registerResponse);
            }
        });*/
    }
}