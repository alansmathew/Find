package com.example.findmydevice;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import android.Manifest;
import android.content.Context;
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
import java.sql.Ref;

public class RegisterActivity extends Activity {
    TextView reg_signin;
    EditText reg_username,reg_password,reg_confirm_password;
    Button reg_register;

    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.register);
        reg_signin = (TextView)findViewById(R.id.reg_signin);
        reg_username=(EditText) findViewById(R.id.reg_username);
        reg_password=(EditText) findViewById(R.id.reg_password);
        reg_confirm_password=(EditText) findViewById(R.id.reg_confirm_password);
        reg_register=(Button) findViewById(R.id.reg_register);


//        reg_username.setBackground(Color.R.drawable.warning.xml);


        reg_register.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String reg_user=reg_username.getText().toString();
                String reg_pass=reg_password.getText().toString();
                String reg_confirm_pass=reg_confirm_password.getText().toString();

                if(reg_user != " " && reg_pass != " " && reg_confirm_pass != " ")
                {
//                    if(reg_password.getText().toString() == reg_confirm_password.getText().toString()) {
                        try
                        {
                            JSONObject jsonParam = new JSONObject();
                            jsonParam.put("username", reg_username.getText().toString());
                            jsonParam.put("password", reg_password.getText().toString());
                            jsonParam.put("fun", "reg");
                            String data= jsonParam.toString();
//                            viewloc.setText(data);
                            Submit(data);
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
//                    }
//                    else{
//                        Toast.makeText(RegisterActivity.this,"Password dosnt match",Toast.LENGTH_LONG).show();
//                    }
                }
                else{
                    Toast.makeText(RegisterActivity.this,"Fill up all fields",Toast.LENGTH_LONG).show();
                }

            }

            private void Submit(String data)
            {
                final String savedata = data;
                String url = "https://3gksn22kik.execute-api.me-south-1.amazonaws.com/production/findmydevice";
                RequestQueue requestQueue = Volley.newRequestQueue(RegisterActivity.this);
                StringRequest stringRequest = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject objres = new JSONObject(response);
                            Toast.makeText(RegisterActivity.this,objres.toString(),Toast.LENGTH_LONG).show();
//                            viewloc.setText(objres.toString());
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

//        public void setWarning(){
//            reg_username.setHint("Username taken");
//        }

        reg_signin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(RegisterActivity.this,MainActivity.class);
                startActivity(intent);
            }
        });


    }
}
