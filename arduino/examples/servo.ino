#include <Servo.h>

Servo servo_1;

int val;

void setup() {
  servo_1.attach(2);
}

void loop() {
  servo_1.write(45);
  delay(1000);
  servo_1.write(0);
  delay(1000);
}