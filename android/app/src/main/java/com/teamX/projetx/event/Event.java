package com.teamX.projetx.event;

/**
 * Created by Paul on 19/07/2017.
 */

public class Event {
    private String title;
    private String content;

    public Event(String title, String content){
        this.title = title;
        this.content = content;
    }

    public String getContent() {
        return content;
    }

    public String getTitle() {

        return title;
    }
}
