package com.teamX.projetx.database;

import cz.msebera.android.httpclient.Header;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.loopj.android.http.RequestParams;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by Paul on 12/07/2017.
 */

public class DataBaseUserInteraction {

    /**
     *
     */
    private DataBaseUserInteraction(){}

    /**
     *
     * @param nickname
     * @param mail
     * @param password
     */
    public static void userRegister(final String nickname, final String mail, final String password) {
        RequestParams params = new RequestParams();
        params.put("nickname", nickname);
        params.put("password", password);
        params.put("mail", mail);

        DataBaseRestClient.post("rest/register", params, new JsonHttpResponseHandler() {
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

    /**
     *
     * @param nickname
     * @param password
     */
    public static void userLogin(final String nickname, final String password) {
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
