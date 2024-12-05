package main

import (
	"reflect"
	"testing"

	"github.com/djlechuck/advent-of-code/utils"
)

var (
	testL = []int{1, 2, 3, 3, 3, 4}
	testR = []int{3, 3, 3, 4, 5, 9}
)

func TestProcessInput(t *testing.T) {
	in := utils.ParseInput("../../../inputs/2024/01_example.txt")
	l, r := processInput(in)

	if !reflect.DeepEqual(l, testL) {
		t.Errorf("processInput() - l: got %v, want %v", l, testL)
	}
	if !reflect.DeepEqual(r, testR) {
		t.Errorf("processInput() - r: got %v, want %v", r, testR)
	}
}

func TestPartOne(t *testing.T) {
	expected := 11.0

	result, _ := partOne(testL, testR)
	if result != expected {
		t.Errorf("partOne() = %f, want %f", result, expected)
	}
}

func TestPartTwo(t *testing.T) {
	expected := 31

	result, _ := partTwo(testL, testR)
	if result != expected {
		t.Errorf("partTwo() = %d, want %d", result, expected)
	}
}
