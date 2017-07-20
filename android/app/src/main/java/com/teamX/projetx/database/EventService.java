package com.teamX.projetx.database;

import retrofit2.Call;
import retrofit2.http.Multipart;
import retrofit2.http.POST;
import retrofit2.http.Part;

/**
 * Created by Paul on 14/07/2017.
 */

public interface EventService {

    enum JSONResponses{

    }

    @Multipart
    @POST("event/create")
    Call<String> eventCreation(@Part("name") String name, @Part("description") String description, @Part("data") String date);
}