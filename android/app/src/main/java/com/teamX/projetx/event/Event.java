package com.teamX.projetx.event;

/**
 * Created by Paul on 19/07/2017.
 */

public class Event {
    private final Integer secret;
    private final String theme;
    private final Integer date;
    private final String address;
    private final Integer creation_time;
    private String name;
    private String description;

    public Event(String name, String description, Integer creation_time, String address, Integer date, String theme, Integer secret){
        this.name = name;
        this.description = description;
        this.creation_time = creation_time;
        this.address = address;
        this.date = date;
        this.theme = theme;
        this.secret = secret;
    }

    public String getDescription() {
        return description;
    }

    public String getName() {
        return name;
    }

    public Integer getSecret() {
        return secret;
    }

    public String getTheme() {
        return theme;
    }

    public Integer getDate() {
        return date;
    }

    public String getAddress() {
        return address;
    }

    public Integer getCreation_time() {
        return creation_time;
    }
}
