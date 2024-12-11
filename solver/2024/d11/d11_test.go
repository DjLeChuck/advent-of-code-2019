package main

import (
	"reflect"
	"testing"

	"github.com/djlechuck/advent-of-code/utils"
)

var (
	parsedInput = field{125, 17}
)

func TestProcessInput(t *testing.T) {
	in := utils.ParseInput("../../../inputs/2024/11_example.txt")
	e := processInput(in)

	if !reflect.DeepEqual(e, parsedInput) {
		t.Errorf("processInput(): got %v, want %v", e, parsedInput)
	}
}

func TestBlink(t *testing.T) {
	expected := 55312

	result, _ := blink(parsedInput, 25)
	if result != expected {
		t.Errorf("scoring() = %d, want %d", result, expected)
	}
}
