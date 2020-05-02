package com.example.findmydevice;

import androidx.annotation.NonNull;
import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import android.Manifest;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Build;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;
import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;
import java.io.UnsupportedEncodingException;

public class MainActivity extends AppCompatActivity {
    Button getloc,login;
    EditText viewloc,username,password;
    TextView register;
    LocationManager locationManager;
    LocationListener locationListener;
    String user ;

    @RequiresApi(api = Build.VERSION_CODES.M)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        login=(Button)findViewById(R.id.login);
        username=(EditText) findViewById(R.id.username);
        password=(EditText)findViewById(R.id.password);
        register=(TextView)findViewById(R.id.register);

        //        getloc = (Button) findViewById(R.id.getloc);
//        viewloc = (EditText) findViewById(R.id.location);

        register.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(MainActivity.this,RegisterActivity.class);
                startActivity(intent);
            }
        });

        login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (checkSelfPermission(Manifest.permission.INTERNET) != PackageManager.PERMISSION_GRANTED){
                    ActivityCompat.requestPermissions(MainActivity.this,new String[]{
                            Manifest.permission.INTERNET },10);
                    return;
                }
//                String url="https://3gksn22kik.execute-api.me-south-1.amazonaws.com/production/findmydevice";
                user = username.getText().toString();

                try {
                    JSONObject jsonParam = new JSONObject();
                    jsonParam.put("username", username.getText().toString());
                    jsonParam.put("password", password.getText().toString());
                    jsonParam.put("fun", "usAu");

                    String data= jsonParam.toString();
//                    viewloc.setText(data);
                    Submit(data);
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }

                    private void Submit(String data)
                    {
                        final String savedata = data;
                        String url = "https://3gksn22kik.execute-api.me-south-1.amazonaws.com/production/findmydevice";
                        RequestQueue requestQueue = Volley.newRequestQueue(MainActivity.this);
                        StringRequest stringRequest = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                                try {
                                    JSONObject objres = new JSONObject(response);
                                    if(Integer.parseInt(objres.get("statusCode").toString())==200){
                                        Intent intent = new Intent(MainActivity.this,ShowMap.class);
                                        startActivity(intent);
                                    }
                                    else{
                                        username.setBackground(getResources().getDrawable(R.drawable.warning));
                                        password.setBackground(getResources().getDrawable(R.drawable.warning));
                                    }
//                                  Toast.makeText(getApplicationContext(),objres.toString(),Toast.LENGTH_LONG).show();
                                } catch (JSONException e) {
                                    Toast.makeText(getApplicationContext(), "Server Error", Toast.LENGTH_LONG).show();
                                }
                            }
                        },
                                new Response.ErrorListener() {
                                    @Override
                                    public void onErrorResponse(VolleyError error) {
                                        Toast.makeText(getApplicationContext(), error.getMessage(), Toast.LENGTH_SHORT).show();
                                    }
                                }
                        ) {
                            @Override
                            public String getBodyContentType() {
                                return "application/json; charset=utf-8";
                            }

                            @Override
                            public byte[] getBody() throws AuthFailureError {
                                try {
                                    return savedata == null ? null : savedata.getBytes("utf-8");
                                } catch (UnsupportedEncodingException uee) {
                                    //Log.v("Unsupported Encoding while trying to get the bytes", data);
                                    return null;
                                }
                            }
                        };

                        requestQueue.add(stringRequest);
                    }
        });

        username.setOnFocusChangeListener(new View.OnFocusChangeListener() {
            @Override
            public void onFocusChange(View view, boolean b) {
                if(!b){
                    username.setBackground(getResources().getDrawable(R.drawable.border));
                    password.setBackground(getResources().getDrawable(R.drawable.border));
                }
            }
        });

        password.setOnFocusChangeListener(new View.OnFocusChangeListener() {
            @Override
            public void onFocusChange(View view, boolean b) {
                if(!b){
                    username.setBackground(getResources().getDrawable(R.drawable.border));
                    password.setBackground(getResources().getDrawable(R.drawable.border));
                }
            }
        });



//        getloc.setOnClickListener(new View.OnClickListener() {
//            @RequiresApi(api = Build.VERSION_CODES.M)
//            @Override
//            public void onClick(View view) {
//                viewloc.setText("Some unknown error 001");
//                locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);
//                if (checkSelfPermission(Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED &&
//                        checkSelfPermission(Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED &&
//                        checkSelfPermission(Manifest.permission.INTERNET) != PackageManager.PERMISSION_GRANTED &&
//                        checkSelfPermission(Manifest.permission.ACCESS_WIFI_STATE) != PackageManager.PERMISSION_GRANTED &&
//                        checkSelfPermission(Manifest.permission.ACCESS_NETWORK_STATE) != PackageManager.PERMISSION_GRANTED &&
//                        checkSelfPermission(Manifest.permission.CHANGE_WIFI_STATE) != PackageManager.PERMISSION_GRANTED &&
//                        checkSelfPermission(Manifest.permission.CHANGE_NETWORK_STATE) != PackageManager.PERMISSION_GRANTED){
//                    ActivityCompat.requestPermissions(MainActivity.this,new String[]{
//                            Manifest.permission.ACCESS_FINE_LOCATION,
//                            Manifest.permission.ACCESS_COARSE_LOCATION,
//                            Manifest.permission.INTERNET,
//                            Manifest.permission.ACCESS_WIFI_STATE,
//                            Manifest.permission.ACCESS_NETWORK_STATE,
//                            Manifest.permission.CHANGE_WIFI_STATE,
//                            Manifest.permission.CHANGE_NETWORK_STATE }, 10);
//                    return;
//                }
//                Location location = locationManager.getLastKnownLocation(LocationManager.GPS_PROVIDER);
//                String latitude = Double.toString(location.getLatitude());
//                String longitude = Double.toString(location.getLongitude());
//                viewloc.setText(latitude+","+longitude);
//                Toast.makeText(MainActivity.this,"hello", Toast.LENGTH_LONG).show();
//            }
//        });
 }
}
