// C++ code
//
#define led 2
#define btnToggle 3
int state = 1;
void setup()
{
  pinMode(led, OUTPUT);
  pinMode(btnToggle, INPUT);
}

void loop()
{
  if(digitalRead(btnToggle) == 1){
    if(state == 1){
      digitalWrite(led, 1);
      state = 0;
    } else {
      state = 1;
      digitalWrite(led, 0);
    }
    
  	delay(10); // Wait for 1000 millisecond(s)
  }
 
}