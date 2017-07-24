package com.teamX.projetx.event;

import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.teamX.projetx.R;

import java.util.ArrayList;

/**
 *
 */
class EventAdapter extends RecyclerView.Adapter<EventAdapter.EventViewHolder> {
    private ArrayList<Event> eventList;

    EventAdapter(ArrayList<Event> eventList) {
        System.out.println("EVENTLIST = " + eventList.size());
        this.eventList = eventList;
    }

    @Override
    public int getItemCount() {
        return eventList.size();
    }

    @Override
    public void onBindViewHolder(EventViewHolder contactViewHolder, int i) {
        Event ci = eventList.get(i);
        contactViewHolder.title.setText(ci.getName());
        contactViewHolder.content.setText(ci.getDescription());
    }

    @Override
    public EventViewHolder onCreateViewHolder(ViewGroup viewGroup, int i) {
        View itemView = LayoutInflater.
                from(viewGroup.getContext()).
                inflate(R.layout.fragment_events_card, viewGroup, false);

        return new EventViewHolder(itemView);
    }

    class EventViewHolder extends RecyclerView.ViewHolder {
        private TextView title;
        private TextView content;

        EventViewHolder(View v) {
            super(v);
            title =  (TextView) v.findViewById(R.id.fragment_event_card_name);
            content = (TextView)  v.findViewById(R.id.fragment_event_card_description);
        }
    }
}