package com.teamX.projetx.DataBase;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.loopj.android.http.RequestParams;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import cz.msebera.android.httpclient.Header;

/**
 * Created by Paul on 12/07/2017.
 */

public class DataBaseUserInteraction {
    public static void userRegister(String nickname, String mail, String password){
        RequestParams params = new RequestParams();
        params.put("nickname", nickname);
        params.put("password", password);
        params.put("mail", mail);

        DataBaseRestClient.post("register", params, new JsonHttpResponseHandler() {
            @Override
            public void onSuccess(int statusCode, Header[] headers, JSONObject response) {
                // If the response is JSONObject instead of expected JSONArray
                System.out.println(statusCode);
                System.out.println(response);
            }

            @Override
            public void onSuccess(int statusCode, Header[] headers, JSONArray timeline) {
                // Pull out the first event on the public timeline
                JSONObject firstEvent = null;
                try {
                    firstEvent = (JSONObject) timeline.get(0);
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                //String tweetText = firstEvent.getString("text");

                // Do something with the response
                System.out.println(firstEvent);
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONArray errorResponse) {
                System.out.println(errorResponse);
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject errorResponse){
                // If the response is JSONObject instead of expected JSONArray
                System.out.println(errorResponse);
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, String responseString, Throwable throwable) {
                System.out.println(DataBaseRestClient.getResponseError(responseString));
            }
        });
    }

    public static void userLogin(String nickname, String password){
        RequestParams params = new RequestParams();
        params.put("nickname", nickname);
        params.put("password", password);

        DataBaseRestClient.post("login", params, new JsonHttpResponseHandler() {
            @Override
            public void onSuccess(int statusCode, Header[] headers, JSONObject response) {
                // If the response is JSONObject instead of expected JSONArray
                System.out.println(statusCode);
                System.out.println(response);
            }

            @Override
            public void onSuccess(int statusCode, Header[] headers, JSONArray timeline) {
                // Pull out the first event on the public timeline
                JSONObject firstEvent = null;
                try {
                    firstEvent = (JSONObject) timeline.get(0);
                } catch (JSONException e) {
                    e.printStackTrace();
                }
                //String tweetText = firstEvent.getString("text");

                // Do something with the response
                System.out.println(firstEvent);
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONArray errorResponse) {
                System.out.println(errorResponse);
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject errorResponse){
                // If the response is JSONObject instead of expected JSONArray
                System.out.println(errorResponse);
            }

            @Override
            public void onFailure(int statusCode, Header[] headers, String responseString, Throwable throwable) {
                System.out.println(DataBaseRestClient.getResponseError(responseString));
            }
        });
    }
}
