package com.teamX.projetx.event.event_fragment;

/**
 * Created by Paul on 24/07/2017.
 */

import android.view.View;

/**
 *
 */
public interface EventClickListener {
    void onClick(View view, int position);

    void onLongClick(View view, int position);
}
