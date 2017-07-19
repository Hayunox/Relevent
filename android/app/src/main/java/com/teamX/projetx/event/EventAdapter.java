package com.teamX.projetx.event;

import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.teamX.projetx.R;

import java.util.List;

/**
 * Created by Paul on 19/07/2017.
 */

public class EventAdapter extends RecyclerView.Adapter<EventAdapter.EventViewHolder> {
    private List<Event> eventList;

    public EventAdapter(List<Event> eventList) {
        this.eventList = eventList;
    }

    @Override
    public int getItemCount() {
        return eventList.size();
    }

    @Override
    public void onBindViewHolder(EventViewHolder contactViewHolder, int i) {
        Event ci = eventList.get(i);
        contactViewHolder.title.setText(ci.getTitle());
        contactViewHolder.content.setText(ci.getContent());
    }

    @Override
    public EventViewHolder onCreateViewHolder(ViewGroup viewGroup, int i) {
        View itemView = LayoutInflater.
                from(viewGroup.getContext()).
                inflate(R.layout.fragment_events_card, viewGroup, false);

        return new EventViewHolder(itemView);
    }

    class EventViewHolder extends RecyclerView.ViewHolder {
        protected TextView title;
        protected TextView content;

        public EventViewHolder(View v) {
            super(v);
            title =  (TextView) v.findViewById(R.id.fragment_event_card_title);
            content = (TextView)  v.findViewById(R.id.fragment_event_card_content);
        }
    }
}