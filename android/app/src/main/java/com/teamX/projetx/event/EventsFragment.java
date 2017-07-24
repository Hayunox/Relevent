package com.teamX.projetx.event;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.DefaultItemAnimator;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import com.teamX.projetx.R;
import com.teamX.projetx.database.DataBase;
import com.teamX.projetx.database.EventService;
import com.teamX.projetx.user.User;
import com.teamX.projetx.utils.AppPreferences;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Response;
import retrofit2.Retrofit;

/**
 * Created by Jb on 16/07/2017.
 */

public class EventsFragment extends Fragment {

    private RecyclerView recyclerView;
    private EventAdapter eventAdapter;
    private User user;
    private ArrayList<Event> userOwnEventList;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.fragment_events, container, false);
        recyclerView = (RecyclerView) rootView.findViewById(R.id.eventList);

        System.out.println("created");

        /**
         * Data
         */
        // user data
        AppPreferences appPreferences = new AppPreferences(recyclerView.getContext());
        this.user = appPreferences.getUserData();

        // user event list
        this.userOwnEventList = new ArrayList<>();

        /**
         * DISPLAY
         */
        // display user own list
        this.displayUserOwnEventList();


        return rootView;
    }

    @Override
    public void onActivityCreated(Bundle savedInstanceState) {
        super.onActivityCreated(savedInstanceState);
    }

    /**
     *
     */
    private void displayUserOwnEventList() {
        //progressBar.setVisibility(View.VISIBLE);
        Retrofit restService = DataBase.getRetrofitService();
        EventService service = restService.create(EventService.class);
        Call<String> call = service.eventListUserOwn(this.user.getKey());

        call.enqueue(new retrofit2.Callback<String>() {
            @Override
            public void onResponse(Call<String> call, Response<String> response) {
                if (response.isSuccessful()) {
                    Gson gson = new Gson();
                    userOwnEventList = gson.fromJson(response.body(), new TypeToken<List<Event>>() {}.getType());
                    eventAdapter = new EventAdapter(userOwnEventList);
                    LinearLayoutManager mLinearLayoutManager = new LinearLayoutManager(getActivity());
                    recyclerView.setAdapter(eventAdapter);
                    recyclerView.setLayoutManager(mLinearLayoutManager);
                    recyclerView.setItemAnimator(new DefaultItemAnimator());
                }
            }

            @Override
            public void onFailure(Call<String> call, Throwable t) {
                t.printStackTrace();
                Toast.makeText(recyclerView.getContext(), "Connection failed", Toast.LENGTH_SHORT).show();
            }
        });
        //progressBar.setVisibility(View.INVISIBLE);
    }
}
