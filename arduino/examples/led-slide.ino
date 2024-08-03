// C++ code

void setup()
{
  Serial.begin(9600);
  pinMode(2, OUTPUT);
  pinMode(3, OUTPUT);
  pinMode(4, OUTPUT);
}

void loop()
{
  for(int i = 2;i <= 5;i++){
    Serial.println(i);
    digitalWrite(i, 1);
    digitalWrite(i-1, 0);
    delay(500);
  }
}