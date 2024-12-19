// C++ code
//
int poten = 0;
#define piezo 2
void setup()
{
  Serial.begin(9600);
  pinMode(piezo, OUTPUT);
  pinMode(A0, INPUT);
}

void loop()
{
  
  poten = analogRead(A0);
  tone(piezo, poten, 1000);
  delay(100);
  noTone(A0);
  delay(1200);
  Serial.println(poten);
  delay(100); // Wait for 1000 millisecond(s)
}