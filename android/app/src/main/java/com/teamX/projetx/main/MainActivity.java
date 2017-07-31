package com.teamX.projetx.main;

import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.TabLayout;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.TextView;

import com.teamX.projetx.R;
import com.teamX.projetx.event.EventCreationActivity;
import com.teamX.projetx.event.invitation.EventInvitationActivity;
import com.teamX.projetx.event.invitation.InvitationFragment;
import com.teamX.projetx.event.event_fragment.EventsFragment;
import com.teamX.projetx.user.ProfileUserActivity;
import com.teamX.projetx.user.User;
import com.teamX.projetx.user.contact.ContactInvitationActivity;
import com.teamX.projetx.user.contact.ContactsFragment;
import com.teamX.projetx.utils.AppPreferences;

import java.util.ArrayList;
import java.util.List;

import static com.teamX.projetx.main.MainActivity.MainFragmentsList.CONTACT_LIST;
import static com.teamX.projetx.main.MainActivity.MainFragmentsList.EVENT_LIST;
import static com.teamX.projetx.main.MainActivity.MainFragmentsList.INVITATION_LIST;

public class MainActivity extends AppCompatActivity {

    private Toolbar toolbar;
    private TabLayout tabLayout;
    private ViewPager viewPager;
    private User user;
    private TextView textViewUserNickname;
    private Intent eventFragmentIntent;
    private Intent contactFragmentIntent;
    private Intent invitationFragmentIntent;
    private ViewPagerAdapter adapter;
    private ImageButton profilepic;

    enum MainFragmentsList{
        EVENT_LIST(0),
        INVITATION_LIST(1),
        CONTACT_LIST(2);

        private int fragmentId;
        MainFragmentsList(int fragmentId){this.fragmentId = fragmentId;}
        public int getFragmentId(){return this.fragmentId;}
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);



        /**
         * Data
         */
        // user data
        AppPreferences appPreferences = new AppPreferences(getBaseContext());
        this.user = appPreferences.getUserData();

        /**
         * Interface
         */
        this.toolbar = (Toolbar) findViewById(R.id.tool_bar);
        setSupportActionBar(this.toolbar);

        this.viewPager = (ViewPager) findViewById(R.id.viewpager);
        setupViewPager(this.viewPager);

        this.profilepic = (ImageButton) findViewById(R.id.imageButtonUserProfilePic);

        this.tabLayout = (TabLayout) findViewById(R.id.tabs);
        this.tabLayout.setupWithViewPager(this.viewPager);
        setupTabIcons();

        this.textViewUserNickname = (TextView) findViewById(R.id.main_activity_user_nickname);
        this.textViewUserNickname.setText(this.user.getNickname());

        /**
         * create profile pic button listener
         */
        this.profilepic.setOnClickListener(new View.OnClickListener() {
             @Override
             public void onClick(View v) {
                 startActivity(new Intent(MainActivity.this, ProfileUserActivity.class));
             }
         });

        /**
         * Bottom floating action button
         */
        this.eventFragmentIntent = new Intent(MainActivity.this, EventCreationActivity.class);
        this.contactFragmentIntent = new Intent(MainActivity.this, ContactInvitationActivity.class);
        this.invitationFragmentIntent = new Intent(MainActivity.this, EventInvitationActivity.class);

        FloatingActionButton fab = (FloatingActionButton) findViewById(R.id.main_activity_floating_add_event);
        fab.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(viewPager.getCurrentItem() == EVENT_LIST.getFragmentId()){
                    startActivity((eventFragmentIntent));
                }else if(viewPager.getCurrentItem() == INVITATION_LIST.getFragmentId()){
                    startActivity((invitationFragmentIntent));
                }else if(viewPager.getCurrentItem() == CONTACT_LIST.getFragmentId()){
                    startActivity((contactFragmentIntent));
                }
            }
        });
    }


    @Override

    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }
    /*@Override
    public boolean onOptionsItemSelected(MenuItem item) {
        super.onOptionsItemSelected(item);
        if (item.getItemId() == R.id.add_item) {
                Toast.makeText(this, "Add item", Toast.LENGTH_SHORT).show();
            }
            return true;
        }*/

    /**
     * Adding custom view to tab
     */
    private void setupTabIcons() {

        TextView tabOne = (TextView) LayoutInflater.from(this).inflate(R.layout.main_viewpager_tab, null);
        tabOne.setText("News");
        tabOne.setCompoundDrawablesWithIntrinsicBounds(0, R.drawable.ic_notifications_black_24dp, 0, 0);
        tabLayout.getTabAt(EVENT_LIST.getFragmentId()).setCustomView(tabOne);

        TextView tabTwo = (TextView) LayoutInflater.from(this).inflate(R.layout.main_viewpager_tab, null);
        tabTwo.setText("Invitations");
        tabTwo.setCompoundDrawablesWithIntrinsicBounds(0, R.drawable.ic_home_black_24dp, 0, 0);
        tabLayout.getTabAt(INVITATION_LIST.getFragmentId()).setCustomView(tabTwo);

        TextView tabThree = (TextView) LayoutInflater.from(this).inflate(R.layout.main_viewpager_tab, null);
        tabThree.setText("Contacts");
        tabThree.setCompoundDrawablesWithIntrinsicBounds(0, R.drawable.ic_info_black_24dp, 0, 0);
        tabLayout.getTabAt(CONTACT_LIST.getFragmentId()).setCustomView(tabThree);
    }

    /**
     * Adding fragments to ViewPager
     * @param viewPager
     */
    private void setupViewPager(ViewPager viewPager) {
        this.adapter = new ViewPagerAdapter(getSupportFragmentManager());
        adapter.addFrag(new EventsFragment(), "News");
        adapter.addFrag(new InvitationFragment(), "Invitations");
        adapter.addFrag(new ContactsFragment(), "Contacts");
        viewPager.setAdapter(adapter);
    }
}

class ViewPagerAdapter extends FragmentPagerAdapter {
    private final List<Fragment> mFragmentList = new ArrayList<>();
    private final List<String> mFragmentTitleList = new ArrayList<>();

    public ViewPagerAdapter(FragmentManager manager) {
        super(manager);
    }

    @Override
    public Fragment getItem(int position) {
        return mFragmentList.get(position);
    }

    @Override
    public int getCount() {
        return mFragmentList.size();
    }

    public void addFrag(Fragment fragment, String title) {
        mFragmentList.add(fragment);
        mFragmentTitleList.add(title);
    }

    @Override
    public CharSequence getPageTitle(int position) {
        return mFragmentTitleList.get(position);
    }
}
