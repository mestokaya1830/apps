#include <Servo.h>

Servo servo_1;

int trigger = 9;
int echo = 10;
float duration, distance;

void setup() {
  Serial.begin(9600);
  servo_1.attach(2);
  pinMode(trigger, OUTPUT);
  pinMode(echo, INPUT);
}

void loop() {
  digitalWrite(trigger, 1);
  delayMicroseconds(10);
  digitalWrite(trigger, 0);

  duration = pulseIn(echo, 1);
  distance = 0.017 * duration;
  servo_1.write(distance);

  Serial.println(distance);

  delay(500);
}